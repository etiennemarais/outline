<?php
namespace Outline\Test\Generator;

use Outline\Contracts\ApiBlueprint;
use Outline\Test\Template\Lumen\LumenTemplate;
use Outline\Test\Template\Native\NativeTemplate;
use Outline\Transformer\Outline\Transformer;

class Generator
{
    /**
     * @var ApiBlueprint
     */
    private $apiBlueprint;
    private $outputTestsPath;
    private $transformer;

    public function __construct(Transformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param ApiBlueprint $apiBlueprint
     * @return $this
     */
    public function with(ApiBlueprint $apiBlueprint)
    {
        $this->apiBlueprint = $apiBlueprint;
        return $this;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function outputTo($path)
    {
        $this->outputTestsPath = $path;
        return $this;
    }

    /**
     * Gets the result and massages the json data into this format to use inside of the templates is easier to work
     * with.
     *
     * @param string $name
     */
    public function generateTestsFor($name = 'default')
    {
        $jsonDataArray = $this->apiBlueprint->getData();

        $resourceCollection = $this->transformer->transform($jsonDataArray);

        $template = $this->getTemplateClassFromName($name);
        $template->with($resourceCollection)
            ->renderTo($this->outputTestsPath);
    }

    /**
     * @param $name
     * @return \Outline\Contracts\Template
     */
    private function getTemplateClassFromName($name)
    {
        $templateClass = ($name === 'lumen')
            ? LumenTemplate::class
            : NativeTemplate::class;

        return new $templateClass;
    }
}
