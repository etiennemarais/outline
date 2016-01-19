<?php

namespace spec\Outline\ApiBlueprint;

use DrafterPhp\Drafter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApiBlueprintSpec extends ObjectBehavior
{
    function let(Drafter $drafter)
    {
        $this->beConstructedWith($drafter, 'someFileName', 'json', 'ast');
    }

    function it_is_initializable(Drafter $drafter)
    {
        $drafter->input('someFileName')->willReturn($drafter);
        $this->shouldHaveType('Outline\ApiBlueprint\ApiBlueprint');
    }
}
