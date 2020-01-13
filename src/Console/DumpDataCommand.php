<?php

namespace Fatindeed\EmojiHelper\Console;

use Illuminate\Console\Command;

class DumpDataCommand extends Command
{
    /**
     * Codes. bitmap?
     *
     * @var array
     */
    private $_codes = [];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'emoji:dump-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump latest emoji data';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->getCodes();
        $content = '<?php' . PHP_EOL . PHP_EOL;
        $content .= 'return [' . PHP_EOL;
        $seq = 0;
        foreach ($this->_codes as $code => $dec) {
            if ($dec - $seq > 1) {
                if ($seq) {
                    $content .= $this->getLine($seq);
                }
                $this->from = $dec;
            }
            $seq = $dec;
        }
        $content .= $this->getLine($seq);
        $content .= '];' . PHP_EOL;
        $filename = realpath(__DIR__ . '/../../config/emoji-data.php');
        file_put_contents($filename, $content);
        $this->info(basename($filename) . ' updated.');
    }

    /**
     * Get codes from unicode.org.
     *
     * @return void
     *
     * @see https://unicode.org/Public/emoji/12.1/emoji-data.txt
     */
    private function getCodes(): void
    {
        $lines = file('https://unicode.org/Public/emoji/12.1/emoji-data.txt');
        foreach ($lines as $line) {
            $line = trim($line);
            // Skip comments or empty lines
            if (empty($line) || substr($line, 0, 1) == '#') {
                continue;
            }
            $range = explode('..', trim(strstr($line, ';', true)));
            if (count($range) == 1) {
                $this->pushHex($range[0]);
            } elseif (count($range) == 2) {
                $from = hexdec($range[0]);
                $to = hexdec($range[1]);
                for ($i = $from; $i <= $to; $i++) {
                    $this->pushHex(dechex($i));
                }
            } else {
                trigger_error('Invalid code data - ' . $line, E_USER_ERROR);
            }
        }
        asort($this->_codes, SORT_NUMERIC);
    }

    /**
     * Push charactor code.
     *
     * @param string $hex Hex string.
     *
     * @return void
     */
    private function pushHex(string $hex): void
    {
        $dec = hexdec($hex);
        if ($dec > 255) {
            $this->_codes[$hex] = $dec;
        }
    }

    /**
     * Get line.
     *
     * @param int $seq Number.
     *
     * @return string
     */
    private function getLine(int $seq): string
    {
        $text = self::getUnicode($this->from);
        if ($seq != $this->from) {
            $text .= '-' . self::getUnicode($seq);
        }
        return '    \'' . $text . '\',' . PHP_EOL;
    }

    /**
     * Get unicode.
     *
     * @param int $nubmer Number.
     *
     * @return string
     */
    private static function getUnicode(int $nubmer): string
    {
        return '\\x{' . sprintf('%04s', dechex($nubmer)) . '}';
    }
}
