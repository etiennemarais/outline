<?php

use Outline\ApiBlueprint\ApiBlueprint;
use Outline\TestGenerator\TestGenerator;

require_once __DIR__ . '/generated_tests/TestCase.php';
require_once __DIR__ . '/generated_tests/FeaturesTest.php';

class FixtureTestGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Configure the drafter parser and format
        $drafter = new \DrafterPhp\Drafter(__DIR__ . '/../../vendor/bin/drafter');

        // Build a new blueprint object
        $apiBlueprint = new ApiBlueprint($drafter, __DIR__ . '/fixture.apib');

        // Run the thing
        (new TestGenerator)
            ->with($apiBlueprint)
            ->outputTo(__DIR__ . '/generated_tests')
            ->generateTestsFor('lumen');
    }

    public function testRunTestGenerator_GeneratesLumenTestsForApiBlueprint()
    {
        $reflection = new ReflectionClass('FeaturesTest');
        $actualMethods = $reflection->getMethods();
        array_walk(
            $actualMethods,
            function (&$v) {
                $v = $v->getName();
            }
        );

        $this->assertEquals('FeaturesTest', $reflection->getName());

        $expectedMethods = [
            'testGet_Fetching_credits_available_Returns200',
            'testGet_Fetching_credits_available_Returns402',
            'testGet_Fetching_credits_available_Returns401',
        ];

        foreach ($expectedMethods as $index => $method) {
            $this->assertEquals($method, $actualMethods[$index]);
        }
    }
}
