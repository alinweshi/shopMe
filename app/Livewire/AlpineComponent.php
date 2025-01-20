<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Admin;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class AlpineComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    public User $user;
    public $image;
    public $search = '';

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $selectedUserId;
    public $vendors;
    public $admins;
    public function mount()
    {
        $this->admins = Admin::all();
        $this->vendors = Vendor::all();
    }

    public function editUser($userId)
    {
        $user = User::find($userId);

        if ($user) {
            $this->selectedUserId = $user->id;
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->email = $user->email;
            $this->phone = $user->phone;
        }
    }

    public function updateUser()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $user = User::find($this->selectedUserId);

        if ($user) {
            $user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
            ]);

            session()->flash('success', 'User updated successfully.');
            $this->resetModal();
        }
    }

    public function resetModal()
    {
        $this->selectedUserId = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->email = null;
        $this->phone = null;
    }

    public function searchUser()
    {
        $users = User::where('first_name', 'like', value: '%' . $this->search . '%')
            ->orWhere('last_name', 'like', value: '%' . $this->search . '%')
            ->orWhere('email', 'like', value: '%' . $this->search . '%')
            ->orWhere('phone', 'like', value: '%' . $this->search . '%')
            ->orWhere('id', 'like', value: '%' . $this->search . '%')
            ->paginate(8);
        return $users;
    }
    public function clearSearch()
    {
        $this->search = '';
    }
    public function deleteUser(User $user)
    {
        try {
            if ($user) {
                $user->delete();
                session()->flash('success', 'User deleted successfully');
                return;
            }
            session()->flash('error', 'No such user is found');
        } catch (\Exception $e) {
            session()->flash('error', 'User is not deleted, please try again.');
        }
    }
    public function search()
    {
        $this->dispatch('search', $this->search);
    }
    public function handleSearch($query)
    {
        $this->search = $query; // Update the Livewire search property with the input from Alpine.js
    }

    public function render()
    {
        return view('livewire.alpine-component', [
            'isTemporaryFile' => $this->image instanceof TemporaryUploadedFile,
            // 'users' => User::paginate(8),
            'users' => $this->searchUser(),

        ]);
    }
}
