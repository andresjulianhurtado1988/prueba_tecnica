<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */

     protected $addHttpCookie = true;

    protected $except = [
        'api/city/registerCity',
        'api/city/updateCity/*',
        'api/customer/registerCustomer',
        'api/customer/updateCustomer/*',
        'api/product/registerProduct',
        'api/product/updateProduct/*',
        'api/order/registerOrder',
        'api/order/updateOrder/*',
        'api/order/asignProducts',
        'api/order/asignarProductos',
        
        'api/order/deleteProductsAsign/*',
        
    ];
}
