<?php
namespace Outline\Test\Template;

use Outline\Contracts\ResourceCollection;
use Outline\Contracts\Template as TemplateContract;

class Template implements TemplateContract
{
    /**
     * @var ResourceCollection
     */
    private $collection;

    /**
     * @param ResourceCollection $collection
     * @return Template
     */
    public function with(ResourceCollection $collection)
    {
        $this->collection = $collection;
        return $this;
    }

    public function render()
    {
        // Loop over collection
        // Write the test templates here
    }
}
