<?php

namespace App\DesignPatterns\Creational\Factory\Dialogs;

use App\DesignPatterns\Creational\Factory\Buttons\Button;

abstract class Dialog
{
    // Factory Method to create button object
    abstract public function  createButton(): Button;
    public function renderDialog()
    {
        $button = $this->createButton(); //initialize button object
        return "
        #####################
        {$button->display()}
        #####################
        ";
    }
}
