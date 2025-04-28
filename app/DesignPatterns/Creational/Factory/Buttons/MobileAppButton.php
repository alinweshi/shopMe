<?php

namespace App\DesignPatterns\Creational\Factory\Buttons;

class MobileAppButton extends Button
{
    public  function display()
    {
        return 'Mobile';
    }
    public  function onClick() {}
}
