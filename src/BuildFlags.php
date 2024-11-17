<?php

namespace DauntlessBuilder;

enum BuildFlags: int
{
    case UPGRADED_BUILD = 0b0001;
    case INVALID_BUILD = 0b0010;
}
