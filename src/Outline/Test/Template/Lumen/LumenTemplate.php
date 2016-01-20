<?php
namespace Outline\Test\Template\Lumen;

use Outline\Test\Template\Template;
use Outline\Contracts\Template as TemplateContract;
use Text_Template;

class LumenTemplate extends Template implements TemplateContract
{
    const TEMPLATE = 'lumen';
    private $testCaseTemplate;
    private $featuresTestClassTemplate;

    public function __construct()
    {
        $this->setTestCaseTemplate();
        $this->setFeaturesTestClassTemplate();
    }

    public function render()
    {
        // Loop over collection
        // Write the test templates here
    }

    private function setTestCaseTemplate()
    {
        $this->testCaseTemplate = new Text_Template(__DIR__ . '/stubs/TestCase.tpl');
    }

    private function setFeaturesTestClassTemplate()
    {
        $this->featuresTestClassTemplate = new Text_Template(__DIR__ . '/stubs/FeaturesTestClass.tpl');
    }
}
