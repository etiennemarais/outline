# Outline
Parse and generate API Blueprint markdown into Feature/Acceptance tests

[![Build Status](https://travis-ci.org/etiennemarais/outline.svg?branch=master)](https://travis-ci.org/etiennemarais/outline)

## NOTE

This project is still very opinionated about how it parses api blueprint documents and is built entirely for a single use case

### TODO
- I will continue to build this out over time to accept any format of api blueprint document and generate acceptance tests for them

### Example usage

```
// Get the parser
$drafter = new \DrafterPhp\Drafter(__DIR__ . '/../vendor/bin/drafter');

// Build a new blueprint object
$apiBlueprint = new ApiBlueprint($drafter, __DIR__ . '/example.apib');

// Run the thing
(new Generator(new Transformer))
    ->with($apiBlueprint)
    ->outputTo(__DIR__ . '/generated_tests')
    ->generateTestsFor('lumen'); // Entirely only supports laravel style test output
```
