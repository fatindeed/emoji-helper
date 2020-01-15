<?php

namespace Fatindeed\EmojiHelper;

class EmojiHelper
{
    /**
     * Remove emoji characters from a given string.
     *
     * @param string $value Input value.
     *
     * @return string|null
     */
    public static function filter($value)
    {
        static $patterns = null;
        static $replacements = null;
        if (is_null($patterns)) {
            $data = include __DIR__ . '/../config/emoji-data.php';
            $patterns = array_map(
                function ($code) {
                    return '/[' . $code . ']/u';
                },
                $data
            );
        }
        if (is_null($replacements)) {
            $replacements = array_pad([], count($patterns), '');
        }
        return preg_replace($patterns, $replacements, $value);
    }
}
