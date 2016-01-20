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

    /**
     * @param string $outputTestsPath
     */
    public function renderTo($outputTestsPath)
    {
        foreach ($this->getCollection()->getResources() as $resource) {
            $testCases = '';
            foreach ($resource->getActions() as $resourceAction) {
                $method = strtolower($resourceAction['method']);
                $methodLabel = ucfirst($method);
                $endpoint = $resourceAction['attributes']['uriTemplate'];
                $methodName = str_replace(' ', '_', $resourceAction['name']);

                foreach ($resourceAction['examples'] as $example) {
                    array_map(function($responses) use ($method, $methodLabel, $methodName, $endpoint, &$testCases) {
                        $testCaseVars = [
                            'methodName' => $methodName . '_Returns_' . $responses['name'],
                            'method' => $method,
                            'methodLabel' => $methodLabel,
                            'statusCode' => $responses['name'],
                            'endpoint' => $endpoint,
                        ];

                        $this->testCaseTemplate->setVar($testCaseVars);
                        $testCases .= $this->testCaseTemplate->render() . "\n";
                    }, $example['responses']);
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
