<?php

namespace App\DesignPatterns\Structural\Decorator\Shipping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingDecoratorController  extends Controller
{
    public function getShipping(Request $request)
    {
        $shippingMethod = $request->shipping_method;
        $shipping = new BasicShipping();
        $shipping = new ShippingDecorator($shipping);
        return $shipping->getShippingCost();
    }
}
