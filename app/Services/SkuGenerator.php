<?php

namespace App\Services;

use App\Contracts\BaseSkuPartGenerator;
use Illuminate\Support\Str;

class SkuGenerator extends BaseSkuPartGenerator
{
    /**
     * this class generates an SKU based on its default part generators 
     * i.e defaultBrand, defaultProductName, defaultVariantName
     * you may add additional sku part generators by creating protected functions.
     * function names must start with "from" in order to be registered as part generator 
     * ex: fromProductColor
     * 
     * you may set @var $dontUseDefaults to true if you dont want to use the default generators.
     */

    protected bool $dontUseDefaults = false;

    /**
     * Sample custom part generator function
     */
    protected function fromSomethingElse()
    {
        info("SKU Generator: fromSomethingElse(): Called");

        // return Str::padLeft($this->record->id, 4, "0");
        return "";
    }
}
