<?php

namespace DauntlessBuilder;

final class WeaponTalents
{
    private function __construct(
        private array $data
    ) {
    }

    public function get(int $row, int $col): bool
    {
        assert($row >= 0 && $row < 5, "row out of bounds");
        assert($col >= 0 && $col < 5, "column out of bounds");

        return $this->data[$row][$col];
    }

    public function set(int $row, int $col, bool $value): static
    {
        assert($row >= 0 && $row < 5, "row out of bounds");
        assert($col >= 0 && $col < 5, "column out of bounds");

        $this->data[$row][$col] = $value;

        return $this;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function serialize(): int
    {
        $number = 0;

        for ($row = 0; $row < 5; $row++) {
            for ($col = 0; $col < 5; $col++) {
                if ($this->get($row, $col)) {
                    $number |= 1 << ($row * 5 + $col);
                }
            }
        }

        return $number;
    }

    public static function empty(): WeaponTalents
    {
        return new WeaponTalents([
            [false, false, false, false, false],
            [false, false, false, false, false],
            [false, false, false, false, false],
            [false, false, false, false, false],
            [false, false, false, false, false],
        ]);
    }

    public static function parse(int $data): WeaponTalents
    {
        $talents = static::empty();

        for ($i = 0; $i < 25; $i++) {
            $row = floor($i / 5);
            $col = $i % 5;
            $value = ($data & (1 << $i)) !== 0;

            if (!$value) {
                continue;
            }

            $talents->set($row, $col, $value);
        }

        return $talents;
    }
}
