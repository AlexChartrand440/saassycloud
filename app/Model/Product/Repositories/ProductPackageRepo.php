<?php
/**
 * SaaSy Cumulus Demo Project
 * User: jason
 * Date: 12/1/17
 * Time: 12:13 PM
 * License: Public Domain
 */

namespace App\Model\Product\Repositories;


use App\Model\Product\Entities\ProductPackage;
use App\Model\RootRepo;

class ProductPackageRepo extends RootRepo implements ProductPackageRepoInterface{

    protected $model;

    public function __construct(ProductPackage $model){
        $this->model = $model;
    }
}