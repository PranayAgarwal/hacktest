<?hh // strict
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree. An additional grant
 *  of patent rights can be found in the PATENTS file in the same directory.
 *
 */

use namespace HH\Lib\Str;
use function Facebook\FBExpect\expect;

/**
 * @emails oncall+hack_prod_infra
 */
final class StrFormatTest extends PHPUnit_Framework_TestCase {

  public static function provideFormat(): array<mixed> {
    return array(
      tuple(
        Str\format('No format specifiers'),
        'No format specifiers',
      ),
      tuple(
        Str\format('A single %s', 'string specifier'),
        'A single string specifier',
      ),
      tuple(
        Str\format("Width modifiers: %5s %'=5s", 'abc', 'abc'),
        'Width modifiers:   abc ==abc',
      ),
      tuple(
        Str\format(
          'Number specifiers: %d %.3f %.2e %.2E',
          42,
          3.14159,
          1200.,
          1200.,
        ),
        'Number specifiers: 42 3.142 1.20e+3 1.20E+3',
      ),
      tuple(
        Str\format('Base specifiers: %b %o %x %X', 15, 15, 15, 15),
        'Base specifiers: 1111 17 f F',
      ),
      tuple(
        Str\format('Percent specifier: %%'),
        'Percent specifier: %',
      ),
    );
  }

  /** @dataProvider provideFormat */
  public function testFormat(
    string $actual,
    string $expected,
  ): void {
    expect($actual)->toBeSame($expected);
  }
}