<?php

namespace App\Repositories;

use Cart;

use App\Interfaces\CartRepositoryInterface;
use App\Models\User;
use App\Models\Product;

class CartRepository implements CartRepositoryInterface 
{
    public function addOrUpdate($params, $model = null) {
        $mode = 'added';
        if($item = \Cart::get($params['product_id'])) {
            \Cart::update($params['product_id'], array(
                'quantity' => 1
            ));
            $mode = 'updated';
        } else {
            // add the product to cart
            \Cart::session($params['user_id'])->add(array(
                'id' => $model->id,
                'name' => $model->name,
                'price' => $model->price,
                'quantity' => $params['quantity'],
                'attributes' => array(
                    'img' => $model->getFirstMediaUrl('product_images'),
                ),
                // 'associatedModel' => $model
            ));
        }

        return [
            'mode' => $mode,
            'message' => ($mode == 'added') ? 'Item added successfully' : 'Item updated successfully',
            'item' => \Cart::get($params['product_id']),
            'cart_html' => view('cart_html')->render()
        ];
    }

    public function remove($params) {
        Cart::session($params['user_id'])->remove($params['product_id']);

        return [
            'mode' => 'removed',
            'message' => 'Item removed successfully',
            'cart_html' => view('cart_html')->render()
        ];
    }
}
