<?php

namespace App\Interfaces;

interface CartRepositoryInterface 
{

    public function validateQuantity($params);
    
    public function addOrUpdate($params, $model = null);

    public function remove($params);
}