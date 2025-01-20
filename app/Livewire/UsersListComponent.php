<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('layout.app')]
#[Title('Users List')]

class UsersListComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $image;
    public $search = '';
    public User $user;

    #[On('user-created')]
    public function updateUsersList()
    {
        // ...
    }
    #[Computed()]
    public function getUsers()
    {
        $users = User::all();
        return $users;
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
        return view(
            'livewire.users-list-component',
            [
        'isTemporaryFile' => $this->image instanceof TemporaryUploadedFile,
        // 'users' => User::paginate(8),
        'users' => $this->searchUser(),

    ]
        );
        // ->layout('layout.app')->title('Users List');
    }
}
