<?php

namespace App\Contracts;

use Closure;

interface SkuGeneratorInterface
{
    /**
     * By default the sku generator has the following methods all of these methods 
     * can be inherited and change
     * @method productName() - uses the product name to create an sku part
     * @method brand() - uses the product name to create an sku part
     * @method variantName() - uses the product variants name to create an sku part
     * @method variantId() - uses the product variants name to create an sku part
     */

    /**
     * Generates an sku based on the product and variant information
     * @param array $data model data
     * @return string
     */
    public function generate(array $data): string;

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
