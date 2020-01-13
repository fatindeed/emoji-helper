# Emoji Helper

[![Travis][ico-travis-build]][link-travis]
[![PHP from Travis config][ico-php-v]](https://php.net/)
[![Scrutinizer coverage][ico-scrutinizer-coverage]][link-scrutinizer]
[![Scrutinizer code quality][ico-scrutinizer-quality]][link-scrutinizer]

Emoji helper is a tool for you to escape emoji characters.

## Why to escape emoji characters

For MySQL databases which use `utf8` charset, it will occur a error when you insert emoji charactes.

## Suggestion

You shoud try to change database charset to `utf8mb4` first. If you can't, then use this class temporary.

## Usage

1.  Require libaray in composer.

    ```sh
    composer require fatindeed/emoji-helper
    ```

2.  With Laravel or Lumen.

    Register `Fatindeed\EmojiHelper\Http\Middleware\RemoveEmojiCharacters` to your middleware list.

    [For Laravel](https://laravel.com/docs/6.x/middleware#global-middleware)

    [For Lumen](https://lumen.laravel.com/docs/6.x/middleware#global-middleware)

3.  Without Laravel.

    ```php
    use Fatindeed\EmojiHelper\EmojiHelper;
    // code...
    $sqlSafeString = EmojiHelper::filter($originalString);
    ```

[ico-travis-build]: https://img.shields.io/travis/fatindeed/emoji-helper.svg
[ico-php-v]: https://img.shields.io/travis/php-v/fatindeed/emoji-helper.svg
[ico-scrutinizer-build]: https://img.shields.io/scrutinizer/build/g/fatindeed/emoji-helper.svg
[ico-scrutinizer-coverage]: https://img.shields.io/scrutinizer/coverage/g/fatindeed/emoji-helper.svg
[ico-scrutinizer-quality]: https://img.shields.io/scrutinizer/quality/g/fatindeed/emoji-helper.svg

[link-travis]: https://travis-ci.org/fatindeed/emoji-helper
[link-scrutinizer]: https://scrutinizer-ci.com/g/fatindeed/emoji-helper
[link-author]: https://github.com/fatindeed