<?hh // strict
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */

use namespace HH\Lib\Keyset;
use function Facebook\FBExpect\expect;
use type Facebook\HackTest\HackTest;

<<Oncalls('hack')>>
final class KeysetCombineTest extends HackTest {

  public static function provideTestUnion(): vec<mixed> {
    return vec[
      tuple(
        vec[],
        vec[
          vec[],
        ],
        keyset[],
      ),
      tuple(
        keyset[1, 2, 3],
        vec[
          Vector {'the', 'quick', 'brown'},
          HackLibTestTraversables::getKeyedIterator(darray[
            'the' => 'the',
            'quick' => 'quick',
            'brown' => 'brown',
            'fox' => 'jumped',
          ]),
        ],
        keyset[1, 2, 3, 'the', 'quick', 'brown', 'jumped'],
      ),
    ];
  }

  <<DataProvider('provideTestUnion')>>
  public function testUnion<Tv as arraykey>(
    Traversable<Tv> $first,
    Container<Traversable<Tv>> $rest,
    keyset<Tv> $expected,
  ): void {
    expect(Keyset\union($first, ...$rest))->toBeSame($expected);
  }
}
