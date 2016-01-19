<?php
namespace Outline\Contracts;

interface ApiBlueprint
{
    /**
     * @return string
     * @throws \Exception
     */
    public function getData();
}
