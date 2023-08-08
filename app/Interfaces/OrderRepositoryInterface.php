<?php

namespace App\Interfaces;

interface OrderRepositoryInterface 
{
    public function processOrder();
    public function getOrders($user_id = 0);
    public function getOrder($order_id);
}