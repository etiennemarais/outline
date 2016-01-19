<?php

namespace spec\Outline\Transformer\Outline;

use Outline\Resource\ResourceCollection;
use Outline\Transformer\Outline\Transformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Transformer::class);
    }

    function it_should_transform_empty_blueprint_data_into_resource_collection()
    {
        $stub = [];
        $this->transform($stub)->shouldBeAnInstanceOf(ResourceCollection::class);
    }

    function it_should_transform_meta_blueprint_data_into_resource_collection_as_meta()
    {
        $this->transform($this->getMetaStub())
            ->shouldBeAnInstanceOf(ResourceCollection::class);
    }

    /**
     * @return array
     */
    private function getMetaStub()
    {
        return [
            "_version" => "2.2",
            "ast" => [
                "_version" => "4.0",
                "metadata" => [],
                "name" => "Outline",
                "description" => "Outline is a simple package to covert api blueprint format docs",
            ],
        ];
    }
}
