<?php

namespace App\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Model;



/**
 * Defines the sku generator service contract
 * @method string generate()
 * @method self addPartGenerator()
 * @method self clear()
 */
interface SkuGeneratorInterface
{

    /**
     * By default the sku generator has the default methods all of these methods 
     * can be inherited and change
     * @method defaultProductName - uses the product name to create an sku part
     * @method defaultBrand - uses the product name to create an sku part
     * @method defaultVariantName - uses the product variants name to create an sku part
     * @method defaultVariantId - uses the product variants name to create an sku part
     */

    /**
     * Generates an sku based on the product and variant information
     * the default generators assume we are using the ProductVariant model
     * 
     * @param Model $record model to use, you may pass a model with loaded relations
     * @param array $relations an array of relations to load
     * @return string
     */
    public function generate(Model $record, array $relations = []): string;

    /**
     * adds partial generator
     * @param Closure ...$callbacks
     * @return self
     */
    public function addPartGenerator(Closure ...$callbacks): self;


    /**
     * call this method if you want to remove all default generators 
     * before you add your custom generators
     * @return self
     */
    public function clear(): self;
}
