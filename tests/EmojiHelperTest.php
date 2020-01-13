<?php

namespace Fatindeed\EmojiHelper;

use PHPUnit\Framework\TestCase;

class EmojiHelperTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testFilterWithEmojiCharacters($input, $expected)
    {
        // Act
        $result = EmojiHelper::filter($input);
        // Assert
        $this->assertEquals($expected, $result);
    }

    public function additionProvider()
    {
        return [
            "No emoji" => ["No emoji", "No emoji"],
            "copyright sign ©" => ["copyright sign ©", "copyright sign ©"],
            "registered sign ®" => ["registered sign ®", "registered sign ®"],
            "trade mark sign \xe2\x84\xa2" => ["trade mark sign \xe2\x84\xa2", "trade mark sign "],
            "information source \xe2\x84\xb9" => ["information source \xe2\x84\xb9", "information source "],
            "yin yang \xe2\x98\xaf" => ["yin yang \xe2\x98\xaf", "yin yang "],
        ];
    }
}
