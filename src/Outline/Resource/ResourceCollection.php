<?php
namespace Outline\Resource;

use Outline\Contracts\ResourceCollection as ResourceCollectionContract;

class ResourceCollection implements ResourceCollectionContract
{
    private $originalParsedData;
    private $meta;
    private $resources;

    /**
     * ResourceCollection constructor.
     * @param array $originalParsedData
     */
    public function __construct(array $originalParsedData)
    {
        $this->originalParsedData = $originalParsedData;
        $this->setMetaDataOnCollection();
        $this->setResourcesOnCollection();
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    private function setMetaDataOnCollection()
    {
        $this->meta = [];
        if (isset($this->originalParsedData['ast'])) {
            $this->meta = array_only($this->originalParsedData['ast'], [
                'metadata',
                'name',
                'description'
            ]);
        }
    }

    /**
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }

    private function setResourcesOnCollection()
    {
        $this->resources = [];
        if (isset($this->originalParsedData['ast']['resourceGroups'])) {
            foreach ($this->originalParsedData['ast']['resourceGroups'] as $resources) {
                foreach ($resources as $resource) {
                    $this->resources[] = new Resource($resource);
                }
            }
        }
    }
}
