<?php
namespace App\Service;

class Converter
{
 public static function toObject(array $array, $object)
        {
            $class = get_class($object);
            $methods = get_class_methods($class);
            foreach ($methods as $method) {
                var_dump($method);
                preg_match(' /^(set)(.*?)$/i', $method, $results);
                $pre = $results[1]  ?? '';
                $k = $results[2]  ?? '';
                $k = strtolower(substr($k, 0, 1)) . substr($k, 1);
                If ($pre == 'set' && !empty($array[$k])) {
                    $object->$method($array[$k]);
                }
            }
            return $object;
        }
}