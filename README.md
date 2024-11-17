# Dauntless Builder SDK (PHP)

Library for interacting with [Dauntless Builder](https://www.dauntless-builder.com).

**Note**: This is for Dauntless Builder v3+ (Dauntless: Awakened+)

## Features

- Parse Dauntless Builder build ids
- Create new Dauntless Builder build ids
- (SOON) Fetch data from Dauntless Builder

## Usage

```php
<?php

$buildId = "OXDriuTRdpCbCbEbYdUwvupvyM8hE0CLDpaVQIfsI2lR2w_5cnD_IL3beFN2C"; // DB Url looks like this: dauntless-builder.com/b/:buildId

$build = Build::fromId($buildId); // this returns a "Result" type and could contain errors

if ($build->hasError()) {
    $build->panic(); // throw an exception if something went wrong
}

// get the actual build value
$build = $build->value();

// get weapon 1 id?
$weaponId = $build->weapon1->id;

// change level of head to 20 (max)
$build->head->level = 20;
// do more stuff...

// and serialize it again...
$newBuildId = $build->serialize();

// create a new build url
$url = "https://www.dauntless-builder.com/b/$newBuildId";
```

## Versioning

This project is **NOT** using semver but instead the parts are made out of:

- Dauntless Builder Version (Currently: 3)
- Build Version (Currently: 10)
- Incremental Version (increases with changes to this library)

Breaking changes can occur with changes to the build version usually.

## License

MIT
