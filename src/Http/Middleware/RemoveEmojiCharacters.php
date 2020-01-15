<?php

namespace Fatindeed\EmojiHelper\Http\Middleware;

use Fatindeed\EmojiHelper\EmojiHelper;

class RemoveEmojiCharacters extends TransformsRequest
{
    /**
     * Transform the given value.
     *
     * @param string $key   Input key.
     * @param mixed  $value Input value.
     *
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if (is_string($value)) {
            return EmojiHelper::filter($value);
        } else {
            return $value;
        }
    }
}
