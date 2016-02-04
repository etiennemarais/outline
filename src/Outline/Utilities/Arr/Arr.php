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
                $keys[$key] = static::getKeyStructure($value);
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
        $arrayString = Arr::getKeyStructure($array);

        $arrayString = self::cleanAndStringifyArray($arrayString);

        return str_replace("%", $arrayString, $string);
    }

    /**
     * @param array $request
     * @return string
     */
    public static function getRequestBody(array $request)
    {
        $requestBody = json_decode($request['body'], true);

        if (is_null($requestBody)) {
            return "[]";
        }

        $requestBody = self::cleanAndStringifyArray($requestBody);

        return $requestBody;
    }

    /**
     * @param array $request
     * @return string
     */
    public static function getRequestHeaders($request)
    {
        $requestHeaders = array_pluck($request['headers'], 'value', 'name');

        $requestHeaders = self::cleanAndStringifyArray($requestHeaders);

        return $requestHeaders;
    }

    /**
     * @param $arrayString
     * @return mixed|string
     */
    private static function cleanAndStringifyArray($arrayString)
    {
        $arrayString = preg_replace("/(\\d+\\s=>)/i", '', var_export($arrayString, true));
        $arrayString = trim(preg_replace('/\s+/', ' ', $arrayString));
        return $arrayString;
    }
}
