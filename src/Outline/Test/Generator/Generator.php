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
            ->render();
//
//        // Generate test cases from stub
//        $testCaseTemplate = new Text_Template(__DIR__ . '/stubs/' . $name . '/TestCase.tpl');
//
//        $testCases = '';
//        foreach ($requests as $endpoint => $data) {
//            $methodName = str_replace(' ', '_', $data['title']);
//
//            // Remove title to grab all the methods available
//            unset($data['title']);
//            foreach ($data as $method => $statusCode) {
//                foreach ($statusCode as $code) {
//                    $testCaseTemplate->setVar([
//                        'methodName' => $methodName . '_Returns' . $code,
//                        'method' => strtolower($method),
//                        'methodLabel' => title_case($method),
//                        'statusCode' => $code,
//                        'endpoint' => $endpoint,
//                    ]);
//
//                    $testCases .= $testCaseTemplate->render() . "\n";
//                }
//            }
//        }
//
//        // Generate test class from stub
//        $testCaseName = 'FeaturesTest';
//
//        $featuresTestClassTemplate = new Text_Template(__DIR__ . '/stubs/' . $name . '/FeaturesTestClass.tpl');
//        $featuresTestClassTemplate->setVar([
//            'testCaseName' => $testCaseName,
//            'date' => date('Y-m-d', time()),
//            'time' => date('H:i:s', time()),
//            'testCases' => $testCases,
//        ]);
//
//        file_put_contents($this->outputTestsPath . '/' . $testCaseName . '.php', $featuresTestClassTemplate->render());
//
//        $this->outputIfNotInTestingMode($testCaseName);
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
