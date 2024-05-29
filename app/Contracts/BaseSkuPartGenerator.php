<?php

namespace App\Contracts;

use App\Traits\SkuDefaultGenerators;
use Closure;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

abstract class BaseSkuPartGenerator implements SkuGeneratorInterface
{
    use SkuDefaultGenerators;

    /** 
     * an array of information from the model
     * @var array
     */
    protected array $record;

    /**  
     * holds all the sku part generators 
     * 
     * @var array
     */
    protected $generators = [];


    /**
     * set to false if you dont want to load the default generators 
     *  
     * @var bool 
     */
    protected bool $dontUseDefaults = false;

    /** 
     * the default generators use by this class 
     * 
     *  @var array
     */
    private $defaultGenerators = [
        'defaultVariantName',
        'defaultProductName',
        'defaultBrand',
    ];

    public function __construct()
    {
        // Initialize with default generator
        foreach ($this->defaultGenerators as $gen) {
            $this->generators[] = Closure::fromCallable([$this, $gen]);
        }

        // Discover and add new functions as generators
        $this->discoverGenerators();
    }


    protected function discoverGenerators()
    {
        $class = new ReflectionClass($this);
        $methods = $class->getMethods(ReflectionMethod::IS_PROTECTED);

        foreach ($methods as $method) {
            if (Str::startsWith($method->getName(), "from")) {
                // protected methods that starts with "from" are added as generators
                $this->generators[] = Closure::fromCallable([$this, $method->getName()]);
            }
        }
    }

    public function generate(array $data): string
    {
        $this->record = $data;

        $sku = "";
        foreach ($this->generators as $generator) {
            $result = call_user_func($generator);
            $sku .= !empty($result) ? ($result . " ") : "";
        }

        return Str::replace(" ", "-", rtrim($sku));
    }

    public function addPartGenerator(Closure ...$callbacks): self
    {
        foreach ($callbacks as $callback) {
            $this->generators[] = $callback;
        }

        return $this;
    }

    public function clear(): self
    {
        $this->generators = [];

        return $this;
    }

    /**
     * returns 4 letters based on the number of words the argument have
     * @param string $string
     */
    protected function getLetters($string)
    {
        $parts = explode(" ", $string);
        $numWords = count($parts);

        return Str::upper(
            $numWords === 1 ? substr($string, 0, 4) : ($numWords === 2 ? substr($parts[0], 0, 2) . substr($parts[1], 0, 2) :
                implode('', array_map(fn ($part) => $part[0], array_slice($parts, 0, 4))))
        );
    }
}
