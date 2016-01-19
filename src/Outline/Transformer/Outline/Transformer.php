<?php
namespace Outline\Transformer\Outline;

use Outline\Contracts\Transformer as TransformerContract;
use Outline\Resource\ResourceCollection;

class Transformer implements TransformerContract
{
    /**
     * @param array $jsonDataArray
     * @return ResourceCollection
     */
    public function transform(array $jsonDataArray)
    {
        return new ResourceCollection($jsonDataArray);
    }
}
