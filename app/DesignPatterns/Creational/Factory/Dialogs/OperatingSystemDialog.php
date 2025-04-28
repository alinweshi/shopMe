<?php

namespace App\DesignPatterns\Creational\Factory\Dialogs;

use App\DesignPatterns\Creational\Factory\Buttons\Button;
use App\DesignPatterns\Creational\Factory\Buttons\OperatingSystemButton;

class OperatingSystemDialog extends Dialog
{
    public function  createButton(): Button
    {
        return new OperatingSystemButton();
    }
}
