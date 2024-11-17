<?php

namespace DauntlessBuilder;

enum BuildFields: int
{
    // meta
    case Version = 0;
    case Flags = 1;

    // weapon 1
    case Weapon1Id = 2;
    case Weapon1Level = 3;
    case Weapon1Talents = 4;

    // weapon 2
    case Weapon2Id = 5;
    case Weapon2Level = 6;
    case Weapon2Talents = 7;

    // head
    case HeadId = 8;
    case HeadLevel = 9;
    case HeadCell = 10;

    // torso
    case TorsoId = 11;
    case TorsoLevel = 12;
    case TorsoCell1 = 13;
    case TorsoCell2 = 14;

    // arms
    case ArmsId = 15;
    case ArmsLevel = 16;
    case ArmsCell = 17;

    // legs
    case LegsId = 18;
    case LegsLevel = 19;
    case LegsCell1 = 20;
    case LegsCell2 = 21;

    // lantern core
    case LanternCoreId = 22;

    // checksum
    case Checksum = 23;

    public function get(array $data): int
    {
        return $data[$this->value];
    }
}
