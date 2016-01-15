<?php
namespace Outline\ApiBlueprint;

use DrafterPhp\Drafter;

class ApiBlueprint implements ApiBlueprintContract
{
    /**
     * @var Drafter
     */
    private $drafter;
    /**
     * @var \Symfony\Component\Process\Process
     */
    private $process;

    /**
     * ApiBlueprint constructor.
     * @param Drafter $drafter
     * @param $input
     * @param string $format
     */
    public function __construct(Drafter $drafter, $input, $format = 'json')
    {
        $process = $drafter->input($input)
            ->format($format)
            ->build();

        $this->drafter = $drafter;
        $this->process = $process;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getJson()
    {
        return $this->drafter->run($this->process);
    }
}