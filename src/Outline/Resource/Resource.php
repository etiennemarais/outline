<?php
namespace Outline\Resource;

use Outline\Contracts\Resource as ResourceContract;

class Resource implements ResourceContract
{
    private $properties;

    /**
     * Resource constructor.
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
