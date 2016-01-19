<?php
namespace Outline\Contracts;

interface Transformer
{
    /**
     * @param array $jsonDataArray
     */
    public function transform(array $jsonDataArray);
}
