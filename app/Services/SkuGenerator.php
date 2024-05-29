<?php

namespace App\Services;

use App\Contracts\BaseSkuPartGenerator;
use App\Contracts\SkuGeneratorInterface;
use App\Traits\SkuDefaultGenerators;
use Closure;
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
     * you may call the clear method if you dont want other generators when you pass
     * your own callbacks
     */

    protected function fromGalahad()
    {
        return "GAL";
    }
}
