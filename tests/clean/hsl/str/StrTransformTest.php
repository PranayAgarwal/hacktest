<?hh // strict
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */

use namespace HH\Lib\Str;
use function Facebook\FBExpect\expect;
use type Facebook\HackTest\HackTest;
// @oss-disable: use InvariantViolationException as InvariantException;

<<Oncalls('hack')>>
final class StrTransformTest extends HackTest {

  public static function provideCapitalize(): vec<mixed> {
    return vec[
      tuple('foo', 'Foo'),
      tuple('Foo', 'Foo'),
      tuple('123', '123'),
      tuple('-foo', '-foo'),
    ];
  }

  <<DataProvider('provideCapitalize')>>
  public function testCapitalize(
    string $string,
    string $expected,
  ): void {
    expect(Str\capitalize($string))->toBeSame($expected);
  }

  public static function provideCapitalizeWords(): vec<mixed> {
    return vec[
      tuple(
        'the quick brown Fox',
        'The Quick Brown Fox',
      ),
      tuple(
        "\tthe\rquick\nbrown\ffox\vjumped",
        "\tThe\rQuick\nBrown\fFox\vJumped",
      ),
    ];
  }

  <<DataProvider('provideCapitalizeWords')>>
  public function testCapitalizeWords(
    string $string,
    string $expected,
  ): void {
    expect(Str\capitalize_words($string))->toBeSame($expected);
  }

  public static function provideCapitalizeWordsCustomDelimiter(): vec<mixed> {
    return vec[
      tuple(
        'the_quick brown_Fox',
        '_',
        'The_Quick brown_Fox',
      ),
      tuple(
        "\tthe_quick|brown fox\vjumped",
        " _|\t",
        "\tThe_Quick|Brown Fox\vjumped",
      ),
      tuple(
        'the_quick brown_Fox',
        '',
        'The_quick brown_Fox',
      ),
    ];
  }

  <<DataProvider('provideCapitalizeWordsCustomDelimiter')>>
  public function testCapitalizeWordsCustomDelimiter(
    string $string,
    string $delimiter,
    string $expected,
  ): void {
    expect(Str\capitalize_words($string, $delimiter))->toBeSame($expected);
  }

  public static function provideFormatNumber(): vec<mixed> {
    return vec[
      tuple(
        0,
        0,
        '.',
        ',',
        '0',
      ),
      tuple(
        8675309,
        0,
        '.',
        ',',
        '8,675,309',
      ),
      tuple(
        8675309,
        2,
        '.',
        ',',
        '8,675,309.00',
      ),
      tuple(
        8675309,
        2,
        ',',
        '-',
        '8-675-309,00',
      ),
      tuple(
        8675.309,
        2,
        '.',
        ',',
        '8,675.31',
      ),
    ];
  }

  <<DataProvider('provideFormatNumber')>>
  public function testFormatNumber(
    num $number,
    int $decimals,
    string $decimal_point,
    string $thousands_separator,
    string $expected,
  ): void {
    expect(Str\format_number(
      $number,
      $decimals,
      $decimal_point,
      $thousands_separator,
    ))->toBeSame($expected);
  }

  public static function provideLowercase(): vec<mixed> {
    return vec[
      tuple('', ''),
      tuple('hello world', 'hello world'),
      tuple('Hello World', 'hello world'),
      tuple('Jenny: (???)-867-5309', 'jenny: (???)-867-5309'),
    ];
  }

  <<DataProvider('provideLowercase')>>
  public function testLowercase(
    string $string,
    string $expected,
  ): void {
    expect(Str\lowercase($string))->toBeSame($expected);
  }

  public static function providePadLeft(): vec<mixed> {
    return vec[
      tuple('foo', 5, ' ', '  foo'),
      tuple('foo', 5, 'blerg', 'blfoo'),
      tuple('foobar', 1, '0', 'foobar'),
      tuple('foo', 6, '0', '000foo'),
      tuple('foo', 8, '01', '01010foo'),
    ];
  }

  <<DataProvider('providePadLeft')>>
  public function testPadLeft(
    string $string,
    int $total_length,
    string $pad_string,
    string $expected,
  ): void {
    expect(Str\pad_left($string, $total_length, $pad_string))
      ->toBeSame($expected);
  }

  public static function providePadRight(): vec<mixed> {
    return vec[
      tuple('foo', 5, ' ', 'foo  '),
      tuple('foo', 5, 'blerg', 'foobl'),
      tuple('foobar', 1, '0', 'foobar'),
      tuple('foo', 6, '0', 'foo000'),
      tuple('foo', 8, '01', 'foo01010'),
    ];
  }

  <<DataProvider('providePadRight')>>
  public function testPadRight(
    string $string,
    int $total_length,
    string $pad_string,
    string $expected,
  ): void {
    expect(Str\pad_right($string, $total_length, $pad_string))
      ->toBeSame($expected);
  }

  public static function provideRepeat(): vec<mixed> {
    return vec[
      tuple('foo', 3, 'foofoofoo'),
      tuple('foo', 0, ''),
      tuple('', 1000000, ''),
    ];
  }

  <<DataProvider('provideRepeat')>>
  public function testRepeat(
    string $string,
    int $multiplier,
    string $expected,
  ): void {
    expect(Str\repeat($string, $multiplier))->toBeSame($expected);
  }

  public static function provideReplace(): vec<mixed> {
    return vec[
      tuple(
        'goodbye world',
        ' ',
        ' cruel ',
        'goodbye cruel world',
      ),
      tuple(
        'goodbye world',
        '',
        ' cruel ',
        'goodbye world',
      ),
      tuple(
        'goodbye world',
        'blerg',
        ' cruel ',
        'goodbye world',
      ),
      tuple(
        'foo',
        'foo',
        'bar',
        'bar',
      ),
      tuple(
        'goodbye cold world',
        'Cold',
        'cruel',
        'goodbye cold world',
      ),
    ];
  }

  <<DataProvider('provideReplace')>>
  public function testReplace(
    string $haystack,
    string $needle,
    string $replacement,
    string $expected,
  ): void {
    expect(Str\replace($haystack, $needle, $replacement))->toBeSame($expected);
  }

  public static function provideReplaceCI(): vec<mixed> {
    return vec[
      tuple(
        'goodbye world',
        ' ',
        ' cruel ',
        'goodbye cruel world',
      ),
      tuple(
        'goodbye world',
        '',
        ' cruel ',
        'goodbye world',
      ),
      tuple(
        'goodbye world',
        'blerg',
        ' cruel ',
        'goodbye world',
      ),
      tuple(
        'foo',
        'foo',
        'bar',
        'bar',
      ),
      tuple(
        'goodbye cold world',
        'Cold',
        'cruel',
        'goodbye cruel world',
      ),
    ];
  }

  <<DataProvider('provideReplaceCI')>>
  public function testReplaceCI(
    string $haystack,
    string $needle,
    string $replacement,
    string $expected,
  ): void {
    expect(Str\replace_ci($haystack, $needle, $replacement))
      ->toBeSame($expected);
  }

  public static function provideReplaceEvery(): vec<mixed> {
    return vec[
      tuple(
        'hello world',
        dict[
          'hello' => 'goodbye',
          'world' => 'cruel world',
        ],
        'goodbye cruel world',
      ),
      tuple(
        'hello world',
        Map {
          'hello' => '',
          'world' => 'cruel world',
          'blerg' => 'nonexistent',
        },
        ' cruel world',
      ),
      tuple(
        'hello world',
        dict[
          'Hello' => 'goodbye',
          'world' => 'cruel world',
        ],
        'hello cruel world',
      ),
      tuple(
        'hello world',
        darray[],
        'hello world',
      ),
    ];
  }

  <<DataProvider('provideReplaceEvery')>>
  public function testReplaceEvery(
    string $haystack,
    KeyedContainer<string, string> $replacements,
    string $expected,
  ): void {
    expect(Str\replace_every($haystack, $replacements))->toBeSame($expected);
  }

  public static function provideSplice(): vec<mixed> {
    return vec[
      tuple(
        '',
        '',
        0,
        null,
        '',
      ),
      tuple(
        'hello world',
        'darkness',
        6,
        null,
        'hello darkness',
      ),
      tuple(
        'hello world',
        ' cruel ',
        5,
        1,
        'hello cruel world',
      ),
      tuple(
        'hello world',
        ' cruel ',
        -6,
        1,
        'hello cruel world',
      ),
      tuple(
        'hello world',
        ' cruel',
        5,
        0,
        'hello cruel world',
      ),
      tuple(
        'hello ',
        'darkness',
        6,
        null,
        'hello darkness',
      ),
      tuple(
        'hello world',
        'darkness',
        6,
        100,
        'hello darkness',
      ),
    ];
  }

  <<DataProvider('provideSplice')>>
  public function testSplice(
    string $string,
    string $replacement,
    int $offset,
    ?int $length,
    string $expected,
  ): void {
    expect(Str\splice($string, $replacement, $offset, $length))
      ->toBeSame($expected);
  }

  public function testSpliceExceptions(): void {
    expect(() ==> Str\splice('hello world', ' cruel ', -12, 1))
      ->toThrow(InvariantException::class);
    expect(() ==> Str\splice('hello world', ' cruel ', 100, 1))
      ->toThrow(InvariantException::class);
  }

  public static function provideToInt(): vec<mixed> {
    return vec[
      tuple('', null),
      tuple('0', 0),
      tuple('8675309', 8675309),
      tuple('8675.309', null),
      tuple('hello world', null),
      tuple('123foo', null),
    ];
  }

  <<DataProvider('provideToInt')>>
  public function testToInt(
    string $string,
    ?int $expected,
  ): void {
    expect(Str\to_int($string))->toBeSame($expected);
  }

  public static function provideUppercase(): vec<mixed> {
    return vec[
      tuple('', ''),
      tuple('hello world', 'HELLO WORLD'),
      tuple('Hello World', 'HELLO WORLD'),
      tuple('Jenny: (???)-867-5309', 'JENNY: (???)-867-5309'),
    ];
  }

  <<DataProvider('provideUppercase')>>
  public function testUppercase(
    string $string,
    string $expected,
  ): void {
    expect(Str\uppercase($string))->toBeSame($expected);
  }

}
