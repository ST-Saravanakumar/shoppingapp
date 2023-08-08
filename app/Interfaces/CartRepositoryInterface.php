<?php

namespace App\Interfaces;

interface CartRepositoryInterface 
{
    public function addOrUpdate($params, $model = null);

    public function remove($params);
}