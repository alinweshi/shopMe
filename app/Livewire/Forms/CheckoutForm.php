<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class CheckoutForm extends Form
{
    #[Rule(rule: 'required|exists:shipping_methods,id')]
    public $selectedShippingMethod = '';

    #[Rule('nullable|nullable|string|exists:coupons,code')]
    public $couponCode = '';

}
