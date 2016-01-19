<?php

namespace spec\Outline\Test\Template;

use Outline\Contracts\ResourceCollection;
use Outline\Test\Template\Template;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TemplateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Template::class);
    }

    function it_sets_the_template_transformer(ResourceCollection $collection)
    {
        $this->with($collection)->shouldReturn($this);
    }
}
