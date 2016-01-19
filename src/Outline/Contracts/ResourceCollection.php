<?php
namespace Outline\Contracts;

interface ResourceCollection
{
    /**
     * @return array
     */
    public function getMeta();

    /**
     * @return array
     */
    public function getResources();
}
