<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\ToDoList;

class TodoForm extends Form
{
    public $title = "";
    public $description = "";
    public function createTodoList(): void
    {
        $todo = ToDoList::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        if ($todo) {
            session()->flash('success', 'Todo created successfully');
        } else {
            session()->flash('error', 'Todo not created');
        }
    }
}
