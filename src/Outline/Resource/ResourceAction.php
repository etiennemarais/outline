<?php
namespace Outline\Resource;

use Outline\Utilities\Arr\Arr;
use Text_Template;

class ResourceAction
{
    private $originalExampleActions;
    private $testCaseTemplate;
    private $params;

    /**
     * @param array $example
     * @param array $params
     */
    public function __construct(array $example, array $params)
    {
        $this->originalExampleActions = $example;
        $this->params = $params;
    }

    public function withTestCaseTemplate(Text_Template $testCaseTemplate)
    {
        $this->testCaseTemplate = $testCaseTemplate;
        return $this;
    }

    public function getTestCases()
    {
        $testCases = '';
        $actionParams = $this->params;

        array_map(function($responses) use ($actionParams, &$testCases) {
            $seeJsonStructure = Arr::replaceWithArrayStringRepresentation(
                "->seeJsonStructure(%)",
                json_decode($responses['body'], true)
            );

            $testCaseVars = [
                'methodName' => $actionParams['methodName'] . '_Returns_' . $responses['name'],
                'method' => $actionParams['method'],
                'methodLabel' => $actionParams['methodLabel'],
                'statusCode' => $responses['name'],
                'endpoint' => $actionParams['endpoint'],
                'seeJsonStructure' => $seeJsonStructure,
            ];

            $this->testCaseTemplate->setVar($testCaseVars);
            $testCases .= $this->testCaseTemplate->render() . "\n";
        }, $this->originalExampleActions['responses']);

        return $testCases;
    }
}
