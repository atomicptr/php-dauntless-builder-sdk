<?php

namespace DauntlessBuilder;

use Atomicptr\Functional\Lst;

final readonly class BuildArmourPiece
{
    public function __construct(
        public int $id,
        public int $level,
        public array $cells,
    ) {
    }

    public static function empty(ArmourType $armourType): static
    {
        return new BuildArmourPiece(
            0,
            1,
            Lst::init(fn () => 0, $armourType->cellCount()),
        );
    }
}
