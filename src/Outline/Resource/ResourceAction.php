<?php
namespace Outline\Resource;

use Outline\Utilities\Arr\Arr;
use Text_Template;

class ResourceAction
{
    private $originalExampleActions;
    private $testCaseTemplate;
    private $actionParams;

    /**
     * @param array $example
     * @param array $actionParams
     */
    public function __construct(array $example, array $actionParams)
    {
        $this->originalExampleActions = $example;
        $this->actionParams = $actionParams;
    }

    /**
     * @param Text_Template $testCaseTemplate
     * @return ResourceAction
     */
    public function withTestCaseTemplate(Text_Template $testCaseTemplate)
    {
        $this->testCaseTemplate = $testCaseTemplate;
        return $this;
    }

    /**
     * @return string
     */
    public function getTestCases()
    {
        $testCases = '';
        $actionParams = $this->actionParams;

        /* Asuming that each response has only one request */
        $request = $this->originalExampleActions['requests'][0];

        array_map(function($responses) use ($actionParams, $request, &$testCases) {
            $seeJsonStructure = Arr::replaceWithArrayStringRepresentation(
                "->seeJsonStructure(%)",
                json_decode($responses['body'], true)
            );

            $requestData = Arr::getRequestBody($request);
            $requestHeaders = Arr::getRequestHeaders($request);

            $testCaseVars = [
                'methodName' => $actionParams['methodName'] . '_Returns_' . $responses['name'],
                'method' => $actionParams['method'],
                'methodLabel' => $actionParams['methodLabel'],
                'statusCode' => $responses['name'],
                'endpoint' => $actionParams['endpoint'],
                'seeJsonStructure' => $seeJsonStructure,
                'requestData' => $requestData,
                'requestHeaders' => $requestHeaders,
            ];

            $this->testCaseTemplate->setVar($testCaseVars);
            $testCases .= $this->testCaseTemplate->render() . "\n";
        }, $this->originalExampleActions['responses']);

        return $testCases;
    }
}
