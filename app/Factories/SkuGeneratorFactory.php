<?php

namespace App\Factories;

use Closure;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

class SkuGeneratorFactory
{

    /**
     * loops thru all the protected properties of the class and adds any methods
     * where the name starts with "from" to the list of generators
     * 
     * @return array
     */
    public static function create($instance, array $defaultGenerators): array
    {
        $generators = [];

        foreach ($defaultGenerators as $defaultGenerator) {
            $generators[$defaultGenerator] = self::makeClosure($instance, $defaultGenerator);
        }

        $class = new ReflectionClass($instance);
        $methods = $class->getMethods(ReflectionMethod::IS_PROTECTED);

        foreach ($methods as $method) {
            if (Str::startsWith($method->getName(), 'from')) {
                $generators[$method->getName()] = self::makeClosure($instance, $method->getName());
            }
        }

        return $generators;
    }

    private static function makeClosure($instance, string $methodName): Closure
    {
        return Closure::bind(function () use ($instance, $methodName) {
            return $instance->$methodName();
        }, null, $instance);
    }
}
