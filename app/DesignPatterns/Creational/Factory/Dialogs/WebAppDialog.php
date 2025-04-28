<?php

namespace App\DesignPatterns\Creational\Factory\Dialogs;

use App\DesignPatterns\Creational\Factory\Buttons\Button;
use App\DesignPatterns\Creational\Factory\Buttons\WebAppButton;
use App\DesignPatterns\Creational\Factory\Buttons\MobileAppButton;

class WebAppDialog extends Dialog
{
    public function  createButton(): Button
    {
        return new WebAppButton();
    }
}
