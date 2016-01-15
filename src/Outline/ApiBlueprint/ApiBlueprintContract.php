<?php
namespace Outline\ApiBlueprint;

interface ApiBlueprintContract
{
    /**
     * @return string
     * @throws \Exception
     */
    public function getJson();
}
