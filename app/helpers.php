<?php

use App\Models\Setting;

if(!function_exists('format_price')) {
    function format_price($value = 0) {
        return env('CURRENCY_SYMBOL').' '.number_format($value, 2);
    }
}

if(!function_exists('format_date')) {
    function format_date($value = 0, $format = 'Y-m-d H:i:s') {
        return date($format, strtotime($value));
    }
}

if(!function_exists('get_settings')) {
    function get_settings($value) {
        $setting = Setting::where('name', $value)->first();
        return $setting->value;
    }
}