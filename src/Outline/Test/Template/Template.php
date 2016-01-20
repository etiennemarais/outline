<?php
namespace Outline\Test\Template;

use Outline\Contracts\ResourceCollection;

class Template
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

    /**
     * @return ResourceCollection
     */
    protected function getCollection()
    {
        return $this->collection;
    }
}
