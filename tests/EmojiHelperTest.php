<?php

namespace Fatindeed\EmojiHelper;

use PHPUnit\Framework\TestCase;

class EmojiHelperTest extends TestCase
{
    /**
     * @dataProvider emojiDataProvider
     */
    public function testFilterWithEmojiCharacters($input, $expected)
    {
        // Act
        $result = EmojiHelper::filter($input);
        // Assert
        $this->assertEquals($expected, $result);
    }

    public function emojiDataProvider()
    {
        return [
            'No emoji' => ['No emoji', 'No emoji'],
            'copyright sign ©' => ['copyright sign ©', 'copyright sign ©'],
            'registered sign ®' => ['registered sign ®', 'registered sign ®'],
            'trade mark sign ™' => ['trade mark sign ™', 'trade mark sign '],
            'information source ℹ' => ['information source ℹ', 'information source '],
            'yin yang ☯' => ['yin yang ☯', 'yin yang '],
        ];
    }
}
