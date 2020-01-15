<?php

namespace Fatindeed\EmojiHelper;

use SplMinHeap;

class CodePoints extends SplMinHeap
{
    /**
     * Insert a code point(decimal).
     *
     * @param number $value Code point.
     *
     * @return void
     */
    public function insert($value)
    {
        $number = intval($value);
        if ($number > 255) {
            parent::insert($number);
        }
    }
}
