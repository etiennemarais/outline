<?php
use Outline\ApiBlueprint\ApiBlueprint;
use Outline\Test\Generator\Generator;
use Outline\Transformer\Outline\Transformer;

// Autoload dependencies
require __DIR__ . "/../vendor/autoload.php";

date_default_timezone_set('Africa/Johannesburg');

// Configure the drafter parser and format
$drafter = new \DrafterPhp\Drafter(__DIR__ . '/../vendor/bin/drafter');

// Build a new blueprint object
$apiBlueprint = new ApiBlueprint($drafter, __DIR__ . '/example.apib');

// Run the thing
(new Generator(new Transformer))
    ->with($apiBlueprint)
    ->outputTo(__DIR__ . '/generated_tests')
    ->generateTestsFor('lumen');
