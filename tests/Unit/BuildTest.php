<?php

use DauntlessBuilder\Build;

test("Build::fromId supports urls", function () {
    $url = "https://www.dauntless-builder.com/b/-M7aDY6lJI5rlCi4r8C_2fbQqwjcl8-mHahKTOMMu0rlY5cp";

    $build = Build::fromId($url);

    expect($build->hasError())->toBeFalse();

    $build = $build->value();
    assert($build instanceof Build);

    expect($build->weapon1->id)->toBe(1);
});

test("Build can serialize/deserialize into the same thing", function () {
    $build = Build::empty();

    $buildId = $build->serialize();
    expect($buildId->hasError())->toBeFalse();

    $buildId = $buildId->value();

    $newBuild = Build::fromId($buildId);
    expect($newBuild->hasError())->toBeFalse();

    expect($buildId)->toBe($newBuild->value()->serialize()->value());
});
