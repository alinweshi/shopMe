<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\UpdateUserComponent;

#[Layout('layout.app')]
#[Title('Show User')]
class ShowUserComponent extends Component
{
    public User $user;/*by doing this you do not need to use mount*/

    // public function mount($id)
    // {
    //     // Fetch the user by `$userId` passed from the route
    //     $this->user = User::findOrFail($id);
    // }
    // public function mount(User $user)
    // {
    //     // Fetch the user by `$userId` passed from the route
    //     $this->user = $user;
    // }
    public function editUser()
    {
        $this->redirectRoute('user.update', parameters: ['user' => $this->user]);
        // redirect('users/'.$this->user->id.'/update'  );
    }


    // Fetch the user by `$userId`

    public function deleteUser()
    {
        if ($this->user) {
            $this->user->delete();
            session()->flash('success', value:  'User successfully deleted.');
            $this->redirect('/index');
        }
        session()->flash('error', value:  'no such user');

    }

    // public function render()
    // {
    //     return view('livewire.show-user-component');
    // }
}
