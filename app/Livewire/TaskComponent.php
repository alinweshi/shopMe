<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class TaskComponent extends Component
{
    use WithPagination;

    public $title = "";
    public $description = "";
    public $search = "";
    public $selectedTaskId = null;


    public function rules()
    {
        return [
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
        ];
    }
    public function save(): void
    {
        //validate
        //create
        //reset input
        //flash message
        $validated = $this->validate();
        $task = Task::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);
        $this->reset(['title', 'description','search']);
        $this->resetPage();

        if ($task) {
            session()->flash('success', 'Task created successfully');
        } else {
            session()->flash('error', 'Task not created');
        }
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $this->selectedTaskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
    }

    public function update()
    {
        $this->validate();

        if ($this->selectedTaskId) {
            $task = Task::findOrFail($this->selectedTaskId);
            $task->update([
                'title' => $this->title,
                'description' => $this->description,
            ]);
            $this-> cancelEdit();
            session()->flash('success', 'Task updated successfully');
        }
    }
    public function cancelEdit()
    {
        $this->reset(['selectedTaskId', 'title', 'description','search']);
    }


    // public function delete($id): void
    // {
    //     Task::findOrFail($id)->delete();
    //     session()->flash('success', 'Task deleted successfully');
    // }
    public function delete(Task $task)
    {
        try {
            if ($task) {
                $task->delete();
                session()->flash('success', 'Task deleted successfully');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Task not deleted');
        }
    }

    public function render()
    {
        // return view('livewire.task-component',['tasks'=>Task::where('title', 'like', "%{$this->search}%")->paginate(2)])
        return view('livewire.task-component', ['tasks' => Task::search($this->search)->paginate(10)])
        ->extends('layout.app')
        ->section('content');
    }
}
