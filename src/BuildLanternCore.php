<?php

namespace DauntlessBuilder;

final readonly class BuildLanternCore
{
    public function __construct(
        public int $id,
    ) {
    }

    public static function empty(): static
    {
        return new BuildLanternCore(0);
    }
}
