<?php

namespace App\Contracts;

use App\Factories\SkuGeneratorFactory;
use App\Traits\SkuDefaultGenerators;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

abstract class BaseSkuPartGenerator implements SkuGeneratorInterface
{
    use SkuDefaultGenerators;

    /** 
     * an array of information from the model
     * @var Model
     */
    protected Model $record;

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
     * the private default generators use by this class 
     * 
     *  @var array
     */
    private $defaultGenerators = [
        'defaultVariantId',
        'defaultVariantName',
        'defaultProductName',
        'defaultBrand'
    ];

    public function __construct()
    {
    }

    public function generate(Model $record, array $relations = []): string
    {
        $this->record = $record->load($relations);

        $this->discoverGenerators();

        return $this->call();
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

    public function dontUseDefaults(bool $value = true): self
    {
        $this->dontUseDefaults = $value;
        return $this;
    }

    /**
     * uses the SkuGeneratorFactory to load all the generators
     * - default generators
     * - custom generators
     */
    private function discoverGenerators()
    {
        $this->generators = array_merge($this->generators, SkuGeneratorFactory::create(
            $this,
            !$this->dontUseDefaults ? $this->defaultGenerators : [],
        ));
    }

    /**
     * loop thru all the generators to create the SKU string
     */
    private function call(): string
    {
        $sku = "";
        foreach ($this->generators as $name => $generator) {
            $result = call_user_func($generator);
            $sku .= !empty($result) ? ($result . " ") : "";
            // info("GENERATOR", [$name, $result]);
        }

        return Str::replace(" ", "-", rtrim($sku));
    }

    /**
     * Returns 4 letters based on the number of words in the argument.
     *
     * @param string $string
     * @return string
     */
    protected static function getLetters($string)
    {
        $parts = explode(" ", $string);
        $numWords = count($parts);

        if ($numWords === 1) {
            return Str::upper(substr($string, 0, 4));
        }

        if ($numWords === 2) {
            return Str::upper(substr($parts[0], 0, 2) . substr($parts[1], 0, 2));
        }

        return Str::upper(implode('', array_map(
            fn ($part) => $part[0],
            array_slice($parts, 0, 4)
        )));
    }
}
