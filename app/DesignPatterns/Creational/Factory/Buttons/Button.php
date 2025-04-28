<?php

namespace App\DesignPatterns\Creational\Factory\Buttons;

abstract class Button
{
    // common interface for all button types
    public abstract function display();
    public abstract function onClick();
}
