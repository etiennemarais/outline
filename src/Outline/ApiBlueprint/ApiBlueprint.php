<?php
namespace Outline\ApiBlueprint;

use DrafterPhp\Drafter;
use Outline\Contracts\ApiBlueprint as ApiBlueprintContract;

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
     * @param string $type
     */
    public function __construct(Drafter $drafter, $input, $format = 'json', $type = 'ast')
    {
        $process = $drafter->input($input)
            ->type($type)
            ->format($format)
            ->build();

        $this->drafter = $drafter;
        $this->process = $process;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getData()
    {
        return json_decode($this->drafter->run($this->process), true);
    }
}