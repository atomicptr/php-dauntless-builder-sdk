<?php

namespace DauntlessBuilder;

enum ArmourType: string
{
    case HEAD = 'head';
    case TORSO = 'torso';
    case ARMS = 'arms';
    case LEGS = 'legs';

    public function cellCount(): int
    {
        return match ($this) {
            self::HEAD => 1,
            self::TORSO => 2,
            self::ARMS => 1,
            self::LEGS => 2,
            default => 0,
        };
    }
}
