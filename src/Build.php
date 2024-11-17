<?php

namespace DauntlessBuilder;

use Atomicptr\Functional\Lst;
use Atomicptr\Functional\Result;
use Sqids\Sqids;

final class Build
{
    public const CURRENT_BUILD_VERSION = 10;
    private const SQIDS_ALPHABET = "tr1GwdIv2NFgTOLso3zfJ95QbenZACWDqiRl@y8haYE7K-cHx6uUPmVX4BkS_0pjM";

    private static ?Sqids $sqids = null;

    public int $version = self::CURRENT_BUILD_VERSION;
    public int $flags = 0;
    public ?BuildWeapon $weapon1 = null;
    public ?BuildWeapon $weapon2 = null;
    public ?BuildArmourPiece $head =  null;
    public ?BuildArmourPiece $torso = null;
    public ?BuildArmourPiece $arms =  null;
    public ?BuildArmourPiece $legs =  null;
    public ?BuildLanternCore $lanternCore = null;
    public int $checksum = 0;

    private function __construct()
    {
        $this->weapon1 ??= BuildWeapon::empty();
        $this->weapon2 ??= BuildWeapon::empty();
        $this->head ??= BuildArmourPiece::empty(ArmourType::HEAD);
        $this->torso ??= BuildArmourPiece::empty(ArmourType::TORSO);
        $this->arms ??= BuildArmourPiece::empty(ArmourType::ARMS);
        $this->legs ??= BuildArmourPiece::empty(ArmourType::LEGS);
        $this->lanternCore ??= BuildLanternCore::empty();
    }

    public function serialize(): Result
    {
        // TODO: do validation

        $data = [
            $this->version,
            $this->flags,
            $this->weapon1->id,
            $this->weapon1->level,
            $this->weapon1->talents->serialize(),
            $this->weapon2->id,
            $this->weapon2->level,
            $this->weapon2->talents->serialize(),
            $this->head->id,
            $this->head->level,
            $this->head->cells[0],
            $this->torso->id,
            $this->torso->level,
            $this->torso->cells[0],
            $this->torso->cells[1],
            $this->arms->id,
            $this->arms->level,
            $this->arms->cells[0],
            $this->legs->id,
            $this->legs->level,
            $this->legs->cells[0],
            $this->legs->cells[1],
            $this->lanternCore->id,
        ];

        $checksum = static::calculateChecksum($data);
        $buildId = static::sqids()->encode([...$data, $checksum]);

        return Result::ok($buildId);
    }

    private static function sqids(): Sqids
    {
        static::$sqids ??= new Sqids(static::SQIDS_ALPHABET);
        return static::$sqids;
    }

    public static function empty(): static
    {
        return new Build();
    }

    public static function fromId(string $buildId): Result
    {
        // we also want to support urls ig
        if (str_starts_with($buildId, "http")) {
            $buildId = Lst::last(explode("/", $buildId));
        }

        $data = static::sqids()->decode($buildId);

        $supposedLength = BuildFields::Checksum->value + 1;

        if (count($data) !== $supposedLength) {
            return Result::error("build '$buildId': length should be $supposedLength");
        }

        $ids = array_slice($data, 0, count($data) - 1);
        $rest = array_slice($data, count($ids));
        $checksum = count($rest) > 0 ? $rest[0] : null;

        if ($checksum === null) {
            return Result::error("build '$buildId': invalid checksum (none)");
        }

        if (!static::checkChecksum($ids, $checksum)) {
            return Result::error("build '$buildId': invalid checksum (check failed)");
        }

        // TODO: do validation

        $build = new Build();
        $build->version = BuildFields::Version->get($data);
        $build->flags = BuildFields::Flags->get($data);

        $build->weapon1 = new BuildWeapon(
            BuildFields::Weapon1Id->get($data),
            BuildFields::Weapon1Level->get($data),
            WeaponTalents::parse(BuildFields::Weapon1Talents->get($data)),
        );

        $build->weapon2 = new BuildWeapon(
            BuildFields::Weapon2Id->get($data),
            BuildFields::Weapon2Level->get($data),
            WeaponTalents::parse(BuildFields::Weapon2Talents->get($data)),
        );

        $build->head = new BuildArmourPiece(
            BuildFields::HeadId->get($data),
            BuildFields::HeadLevel->get($data),
            [
                BuildFields::HeadCell->get($data),
            ],
        );

        $build->torso = new BuildArmourPiece(
            BuildFields::TorsoId->get($data),
            BuildFields::TorsoLevel->get($data),
            [
                BuildFields::TorsoCell1->get($data),
                BuildFields::TorsoCell2->get($data),
            ],
        );

        $build->arms = new BuildArmourPiece(
            BuildFields::ArmsId->get($data),
            BuildFields::ArmsLevel->get($data),
            [
                BuildFields::ArmsCell->get($data),
            ],
        );

        $build->legs = new BuildArmourPiece(
            BuildFields::LegsId->get($data),
            BuildFields::LegsLevel->get($data),
            [
                BuildFields::LegsCell1->get($data),
                BuildFields::LegsCell2->get($data),
            ],
        );

        $build->lanternCore = new BuildLanternCore(
            BuildFields::LanternCoreId->get($data),
        );

        $build->checksum = BuildFields::Checksum->get($data);

        return Result::ok($build);
    }

    private static function calculateChecksum(array $data): int
    {
        $checksum = 0;

        foreach ($data as $val) {
            $checksum ^= $val;
        }

        return $checksum;
    }

    private static function checkChecksum(array $data, int $checksum): bool
    {
        return static::calculateChecksum($data) === $checksum;
    }
}
