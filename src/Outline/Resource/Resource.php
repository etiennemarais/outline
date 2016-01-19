<?php
namespace Outline\Resource;

use Outline\Contracts\Resource as ResourceContract;

class Resource implements ResourceContract
{
    private $properties;
    private $actions;

    /**
     * Resource constructor.
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        $this->setProperties($properties);
        $this->setResourceActions($properties);
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    private function setProperties(array $properties)
    {
        $this->properties = [];
        if (isset($properties)) {
            $this->properties = array_only($properties, [
                'name',
                'description',
                'uriTemplate',
                'parameters',
            ]);
        }
    }

    /**
     * @param array $properties
     */
    private function setResourceActions(array $properties)
    {
        $this->actions = [];
        if (isset($properties['actions'])) {
            foreach ($properties['actions'] as $index => $action) {
                $this->actions[] = $action;
            }
        }
    }
}
