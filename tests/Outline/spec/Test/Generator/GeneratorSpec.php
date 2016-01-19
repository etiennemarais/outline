<?php

namespace spec\Outline\Test\Generator;

use Outline\Test\Generator\Generator;
use Outline\Transformer\Outline\Transformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GeneratorSpec extends ObjectBehavior
{
    function let(Transformer $transformer)
    {
        $this->beConstructedWith($transformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Generator::class);
    }
}
