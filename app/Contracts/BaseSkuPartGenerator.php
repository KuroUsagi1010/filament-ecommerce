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
        $this->generators = SkuGeneratorFactory::create(
            $this,
            !$this->dontUseDefaults ? $this->defaultGenerators : [],
        );
    }

    public function generate(Model $record, array $relations = []): string
    {
        $this->record = $record->load($relations);

        $sku = "";
        foreach ($this->generators as $name => $generator) {
            $result = call_user_func($generator);
            $sku .= !empty($result) ? ($result . " ") : "";
            // info("GENERATOR", [$name, $result]);
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
    protected static function getLetters($string)
    {
        $parts = explode(" ", $string);
        $numWords = count($parts);

        return Str::upper(
            $numWords === 1 ? substr($string, 0, 4) : ($numWords === 2 ? substr($parts[0], 0, 2) . substr($parts[1], 0, 2) :
                implode('', array_map(fn ($part) => $part[0], array_slice($parts, 0, 4))))
        );
    }
}
