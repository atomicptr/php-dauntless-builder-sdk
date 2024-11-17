<?php

use DauntlessBuilder\WeaponTalents;

test('WeaponTalents::set', function () {
    expect(WeaponTalents::empty()->set(0, 0, true)->data())->toBe([
        [true, false, false, false, false],
        [false, false, false, false, false],
        [false, false, false, false, false],
        [false, false, false, false, false],
        [false, false, false, false, false],
    ]);

    expect(WeaponTalents::empty()->set(1, 1, true)->data())->toBe([
        [false, false, false, false, false],
        [false, true, false, false, false],
        [false, false, false, false, false],
        [false, false, false, false, false],
        [false, false, false, false, false],
    ]);

    expect(WeaponTalents::empty()->set(4, 4, true)->data())->toBe([
        [false, false, false, false, false],
        [false, false, false, false, false],
        [false, false, false, false, false],
        [false, false, false, false, false],
        [false, false, false, false, true],
    ]);

    expect(WeaponTalents::empty()->set(1, 1, true)->set(4, 4, true)->data())->toBe([
        [false, false, false, false, false],
        [false, true, false, false, false],
        [false, false, false, false, false],
        [false, false, false, false, false],
        [false, false, false, false, true],
    ]);
});

test('WeaponTalents::parse', function () {
    $matrix = [
        [0, WeaponTalents::empty()->data()],
        [1, WeaponTalents::empty()->set(0, 0, true)->data()],
        [
            0b1111111111111111111111111,
            [
                [true, true, true, true, true],
                [true, true, true, true, true],
                [true, true, true, true, true],
                [true, true, true, true, true],
                [true, true, true, true, true],
            ],
        ],
    ];

    foreach ($matrix as list($input, $expected)) {
        expect(WeaponTalents::parse($input)->data())->toBe($expected);
    }
});

test('WeaponTalents::serialize', function () {
    expect(WeaponTalents::empty()->set(0, 0, true)->serialize())->toBe(1);
});
