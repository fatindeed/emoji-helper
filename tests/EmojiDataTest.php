<?php

namespace Fatindeed\EmojiHelper;

use PHPUnit\Framework\TestCase;

class EmojiDataTest extends TestCase
{
    /**
     * @var string
     */
    private $_tempnam;

    protected function setUp(): void
    {
        $this->_tempnam = tempnam(sys_get_temp_dir(), 'tmp');
    }

    public function testSaveConfigFile()
    {
        // Arrange
        $data = EmojiData::load(__DIR__ . '/emoji-data.txt');
        // Act
        $data->save($this->_tempnam);
        // Assert
        $this->assertFileEquals(__DIR__ . '/../config/emoji-data.php', $this->_tempnam);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->_tempnam)) {
            unlink($this->_tempnam);
        }
    }
}
