<?php

namespace App\Livewire;

use App\Livewire\Forms\TodoForm;
use App\Models\ToDoList;
use Livewire\Component;
use Livewire\WithPagination;

class Todo extends Component
{
    use WithPagination;

    public $title = "";
    public $description = "";
    public $search = "";
    public TodoForm $form;

    public function save(): void
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

    public function edit($id): void
    {
        $todo = ToDoList::findOrFail($id);
        $this->title = $todo->title;
        $this->description = $todo->description;
        $todo->save();
    }

    public function delete($id): void
    {
        ToDoList::findOrFail($id)->delete();
        session()->flash('success', 'Todo deleted successfully');
    }

    public function render()
    {
        return view('livewire.todo', [
            'todos' => ToDoList::paginate(2),
        ])->extends('layout.app')
          ->section('content');
    }
}
