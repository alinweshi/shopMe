<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

#[Layout('layout.app')]
#[Title('Update User')]
class UpdateUserComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $password = '';
    public $image;
    public $selectedUser = '';

    public function mount(User $user)
    {
        $this->selectedUser = $user;
        $this->editUser($this->selectedUser);
    }
    // public UserForm $form;
    protected function rules()
    {
        return [
            'first_name' => 'required|min:5|max:50',
            'last_name' => 'required|min:5|max:50',
            'email' => 'required|email|unique:users,email,'. $this->selectedUser->id,
            'phone' => 'required|string',
            // |size:11|unique:users,phone
            // 'image'=>'required|image|mimes:png,jpg,jpeg|max:2048',
            'password' => [
                'required',
                Password::min(8)
                    // ->letters()
                    // ->mixedCase()
                    // ->numbers()
                    // ->symbols()
                    // ->uncompromised(),
            ],
        ];
    }

    public function editUser(User $user)
    {
        $this->selectedUser = $user;
        // dd($this->selectedUser);
        $this->first_name = $this->selectedUser->first_name;
        $this->last_name = $this->selectedUser->last_name;
        $this->email = $this->selectedUser->email;
        $this->phone = $this->selectedUser->phone;
        $this->password = $this->selectedUser->password;
        $this->image = $this->selectedUser->image;
    }
    public function updateUser()
    {
        $validated = $this->validate();
        $validated['password'] = Hash::make($validated['password']);
        $this->selectedUser->update($validated);
        $this->selectedUser->save();
        $this->dispatch('user-updated.{$this->selectedUser->id}');
        session()->flash('success', 'User Updated Successfully');
        $this->redirectRoute('users');
    }
    public function cancel()
    {
        $this->reset();
        $this->redirectRoute('index');
    }

    public function render()
    {
        return view('livewire.update-user-component', [
                        'isTemporaryFile' => $this->image instanceof TemporaryUploadedFile,
    ]);
    }
}
