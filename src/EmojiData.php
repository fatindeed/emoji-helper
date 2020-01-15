<?php

namespace Fatindeed\EmojiHelper;

class EmojiData
{
    /**
     * The CodePoints instance.
     *
     * @var CodePoints
     */
    private $_codePoints;

    /**
     * Line output from.
     *
     * @var int
     */
    private $_from;

    /**
     * Load new emoji data instance from url.
     *
     * @param string $url Emoji data url.
     *
     * @return EmojiData
     *
     * @see https://unicode.org/Public/emoji/12.1/emoji-data.txt
     */
    public static function load($url)
    {
        $codePoints = new CodePoints();
        $lines = file($url) ?: [];
        foreach ($lines as $line) {
            $line = trim($line);
            // Skip comments or empty lines
            if (empty($line) || substr($line, 0, 1) == '#') {
                continue;
            }
            $data = array_map('hexdec', explode('..', trim(strstr($line, ';', true) ?: '')));
            if (count($data) == 1) {
                $codePoints->insert($data[0]);
            } elseif (count($data) == 2) {
                for ($i = $data[0]; $i <= $data[1]; $i++) {
                    $codePoints->insert($i);
                }
            } else {
                trigger_error('Invalid code data - ' . $line, E_USER_ERROR); // @codeCoverageIgnore
            }
        }
        return new self($codePoints);
    }

    /**
     * Constructs a new emoji data.
     *
     * @param CodePoints $codePoints The CodePoints instance.
     */
    public function __construct(CodePoints $codePoints)
    {
        $this->_codePoints = $codePoints;
    }

    /**
     * Save emoji data config.
     *
     * @param string $filename Path to the file where to write the data.
     *
     * @return void
     */
    public function save($filename)
    {
        $content = '<?php' . PHP_EOL . PHP_EOL;
        $content .= 'return [' . PHP_EOL;
        $seq = 0;
        foreach ($this->_codePoints as $number) {
            if ($number - $seq > 1) {
                if ($seq) {
                    $content .= $this->getLine($seq);
                }
                $this->_from = $number;
            }
            $seq = $number;
        }
        $content .= $this->getLine($seq);
        $content .= '];' . PHP_EOL;
        file_put_contents($filename, $content);
        echo basename($filename) . ' updated.' . PHP_EOL;
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
        $text = self::printCode($this->_from);
        if ($seq != $this->_from) {
            $text .= '-' . self::printCode($seq);
        }
        return '    \'' . $text . '\',' . PHP_EOL;
    }

    /**
     * Print code.
     *
     * @param int $nubmer Number.
     *
     * @return string
     */
    private static function printCode(int $nubmer): string
    {
        return '\\x{' . sprintf('%04s', dechex($nubmer)) . '}';
    }
}
