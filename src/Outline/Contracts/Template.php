<?php
namespace Outline\Contracts;

interface Template
{
    /**
     * @param ResourceCollection $collection
     * @return \Outline\Test\Template\Template
     */
    public function with(ResourceCollection $collection);

    /**
     * @param string $outputTestsPath
     */
    public function renderTo($outputTestsPath);
}
