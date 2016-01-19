<?php

namespace spec\Outline\Resource;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResourceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith($this->getFullStub());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Outline\Resource\Resource');
    }

    function it_should_get_the_properties_it_was_created_with()
    {
        $this->getProperties();
    }

    private function getFullStub()
    {
        return [
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
        ];
    }
}
