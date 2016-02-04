<?php
namespace Outline\Test\Template\Lumen;

use Outline\Resource\ResourceAction;
use Outline\Test\Template\Template;
use Outline\Contracts\Template as TemplateContract;
use Outline\Utilities\Arr\Arr;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
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

    /**
     * @param string $outputTestsPath
     */
    public function renderTo($outputTestsPath)
    {
        $testCases = '';
        foreach ($this->getCollection()->getResources() as $resource) {
            foreach ($resource->getActions() as $resourceAction) {
                $method = strtolower($resourceAction['method']);
                $methodLabel = ucfirst($method);
                $endpoint = $resourceAction['attributes']['uriTemplate'];
                $methodName = str_replace(' ', '_', $resourceAction['name']);
                $getRequestQueryParams = ($method === 'GET')
                    ? $resourceAction['parameters']
                    : [];

                foreach ($resourceAction['examples'] as $example) {
                    $actionParams = [
                        'method' => $method,
                        'methodLabel' => $methodLabel,
                        'methodName' => $methodName,
                        'endpoint' => $endpoint,
                        'queryParams' => $getRequestQueryParams,
                    ];

                    $testCases .= (new ResourceAction($example, $actionParams))
                        ->withTestCaseTemplate($this->testCaseTemplate)
                        ->getTestCases();
                }
            }
        }

        $testCaseName = 'FeaturesTest';
        $this->featuresTestClassTemplate->setVar([
            'testCaseName' => $testCaseName,
            'date' => date('Y-m-d', time()),
            'time' => date('H:i:s', time()),
            'testCases' => $testCases,
        ]);

        $this->saveContentsToFile($outputTestsPath, $testCaseName);
        $this->outputIfNotInTestingMode($testCaseName);
    }

    private function setTestCaseTemplate()
    {
        $this->testCaseTemplate = new Text_Template(__DIR__ . '/stubs/TestCase.tpl');
    }

    private function setFeaturesTestClassTemplate()
    {
        $this->featuresTestClassTemplate = new Text_Template(__DIR__ . '/stubs/FeaturesTestClass.tpl');
    }

    /**
     * @param $testCaseName
     */
    private function outputIfNotInTestingMode($testCaseName)
    {
        if (getenv('APP_ENV') !== 'testing') {
            echo "Written " . $testCaseName . " feature tests.\n\n";
        }
    }

    /**
     * @param $outputTestsPath
     * @param $testCaseName
     */
    private function saveContentsToFile($outputTestsPath, $testCaseName)
    {
        $parts = explode('/', $outputTestsPath);
        $dir = '';
        foreach($parts as $part) {
            if(!is_dir($dir .= "/$part")) mkdir($dir);
        }

        file_put_contents(
            $outputTestsPath . '/' . $testCaseName . '.php',
            $this->featuresTestClassTemplate->render()
        );
    }
}
