<?php
namespace Outline\Utilities\Arr;

class Arr extends \Illuminate\Support\Arr
{
    /**
     * @param array $array
     * @return array
     */
    public static function getKeyStructure(array $array)
    {
        $keys = array();

        foreach ($array as $key => $value) {
            $keys[] = $key;

            if (is_array($value)) {
                $keys[] = static::getKeyStructure($value);
            }
        }

        return $keys;
    }

    /**
     * @param $string
     * @param array $array
     * @return string
     */
    public static function replaceWithArrayStringRepresentation($string, array $array)
    {
        $arrayString = var_export(Arr::getKeyStructure($array), true);

        $arrayString = preg_replace("/(\\d+\\s=>)/i", '', $arrayString);
        $arrayString = trim(preg_replace('/\s+/', ' ', $arrayString));

        return str_replace("%", $arrayString, $string);
    }
}
