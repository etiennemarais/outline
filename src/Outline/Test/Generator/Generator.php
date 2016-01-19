<?php
namespace Outline\Test\Generator;

use Flow\JSONPath\JSONPath;
use Outline\Contracts\ApiBlueprint;
use Outline\Test\Template\Template;
use Outline\Transformer\Outline\Transformer;
use Text_Template;

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
        dd($jsonDataArray);

        $resourceCollection = $this->transformer->transform($jsonDataArray);

        (new Template)
            ->with($resourceCollection)
            ->render();






        $jsonDataArray = json_decode($jsonDataArray, true);

        // TODO, remove json path and badly written algo
        // TODO Create a transformer class with configable structure for override ability
        // TODO Inject that transformer with the json and pass it to a RenderTest class that deals with the templating :)
        // TODO Update the tests to better test output
        // TODO Add response data to the test templates

        $jsonPath = new JSONPath($jsonDataArray);

        // Find all api routes
        $endpoints = $jsonPath->find('..[?(@.element == \'transition\')]');

        $requests = [];
        foreach ($endpoints->data() as $httpTransaction) {
            $endpointPath = $httpTransaction['attributes']['href'];
            $endpointTitle = $httpTransaction['meta']['title'];

            $requests[$endpointPath] = [
                'title' => $endpointTitle,
            ];

            foreach ($httpTransaction['content'] as $transaction) {
                if ($transaction['element'] === 'httpTransaction') {
                    $full = [];
                    foreach ($transaction['content'] as $content) {
                        $full = array_merge_recursive($full, $content);
                    }

                    $method = $full['attributes']['method'];
                    $statusCode = $full['attributes']['statusCode'];

                    $requests[$endpointPath][$method][] = $statusCode;
                }
            }
        }

        // Generate test cases from stub
        $testCaseTemplate = new Text_Template(__DIR__ . '/stubs/' . $name . '/TestCase.tpl');

        $testCases = '';
        foreach ($requests as $endpoint => $data) {
            $methodName = str_replace(' ', '_', $data['title']);

            // Remove title to grab all the methods available
            unset($data['title']);
            foreach ($data as $method => $statusCode) {
                foreach ($statusCode as $code) {
                    $testCaseTemplate->setVar([
                        'methodName' => $methodName . '_Returns' . $code,
                        'method' => strtolower($method),
                        'methodLabel' => title_case($method),
                        'statusCode' => $code,
                        'endpoint' => $endpoint,
                    ]);

                    $testCases .= $testCaseTemplate->render() . "\n";
                }
            }
        }

        // Generate test class from stub
        $testCaseName = 'FeaturesTest';

        $featuresTestClassTemplate = new Text_Template(__DIR__ . '/stubs/' . $name . '/FeaturesTestClass.tpl');
        $featuresTestClassTemplate->setVar([
            'testCaseName' => $testCaseName,
            'date' => date('Y-m-d', time()),
            'time' => date('H:i:s', time()),
            'testCases' => $testCases,
        ]);

        file_put_contents($this->outputTestsPath . '/' . $testCaseName . '.php', $featuresTestClassTemplate->render());

        $this->outputIfNotInTestingMode($testCaseName);
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
}
