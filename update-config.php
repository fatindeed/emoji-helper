<?php

require __DIR__ . '/vendor/autoload.php';

use Fatindeed\EmojiHelper\EmojiData;

$data = EmojiData::load('https://unicode.org/Public/emoji/12.1/emoji-data.txt');
$data->save(__DIR__ . '/config/emoji-data.php');
