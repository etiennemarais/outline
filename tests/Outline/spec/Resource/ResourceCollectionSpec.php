<?php

namespace spec\Outline\Resource;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResourceCollectionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith($this->getMetaStub());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Outline\Resource\ResourceCollection');
    }

    function it_sets_the_empty_meta_collection_data_on_new_collection()
    {
        $this->beConstructedWith([]);
        $this->getMeta()->shouldReturn([]);
    }

    function it_sets_the_meta_collection_data_on_new_collection()
    {
        $this->getMeta()->shouldReturn([
            "metadata" => [],
            "name" => "Outline",
            "description" => "Outline is a simple package to covert api blueprint format docs",
        ]);
    }

    function it_gets_the_resources_from_the_parsed_json()
    {
        $this->beConstructedWith($this->getFullStub());

        $this->getResources()->shouldBeArray();
    }

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

    private function getFullStub()
    {
        return [
            "_version" => "2.2",
            "ast" => [
                "_version" => "4.0",
                "metadata" => [],
                "name" => "Outline",
                "description" => "Outline is a simple package to covert api blueprint format docs",
                "resourceGroups" => [
                    0 => [
                        "resources" => [
                            0 => [
                                "element" => "resource",
                                "name" => "Status",
                                "uriTemplate" => "/status",
                                "actions" => [
                                    "name" => "Fetching credits available",
                                    "description" => "Returns the available credits and does the action of stating whether there is action required of
                                buying new credits if the threshold is below a certain point.",
                                    "method" => "GET",
                                    "attributes" => [
                                        "uriTemplate" => "/status/credits"
                                    ],
                                    "examples" => [
                                        0 => [
                                            "requests" => [],
                                            "responses" => [
                                                "name" => "200"
                                                // TODO add response body
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        ],
                    ],
                ],
            ],
        ];
    }
}
