<?php

namespace Fatindeed\EmojiHelper;

class EmojiHelper
{
    /**
     * Remove emoji characters from a given string.
     *
     * @param string $value Input value
     *
     * @return string
     */
    public static function filter($value)
    {
        static $patterns = null;
        static $replacements = null;
        if (is_null($patterns)) {
            $emojiData = include __DIR__ . '/../config/emoji-data.php';
            $patterns = array_map(
                function ($code) {
                    return '/[' . $code . ']/u';
                },
                $emojiData
            );
        }
        if (is_null($replacements)) {
            $replacements = array_pad([], count($patterns), '');
        }
        return preg_replace($patterns, $replacements, $value);
    }
}
