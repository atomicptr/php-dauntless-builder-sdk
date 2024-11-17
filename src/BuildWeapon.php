<?php

namespace DauntlessBuilder;

final readonly class BuildWeapon
{
    public function __construct(
        public int $id,
        public int $level,
        public WeaponTalents $talents,
    ) {
    }

    public static function empty(): static
    {
        return new BuildWeapon(
            0,
            1,
            WeaponTalents::empty(),
        );
    }
}
