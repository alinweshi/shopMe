<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layout.app')]
#[Title('Users List')]
class UsersPageComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $image;
    public $search = '';
    public User $user;

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $selectedUserId;

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

    public function render()
    {
        return view('livewire.users-page-component', [
            'isTemporaryFile' => $this->image instanceof TemporaryUploadedFile,
            // 'users' => User::paginate(8),
            'users' => $this->searchUser(),

        ]);
    }
}
