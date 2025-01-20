<?php

namespace App\Livewire;

use Exception;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Livewire\Forms\UserForm;
use App\Services\UploadFileService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class IndexComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $password = '';
    public $image;
    public $selectedUser_id = '';
    public $showedUser_id = '';
    public $showedUser = '';


    // public UserForm $form;
    protected function rules()
    {
        return [
            'first_name' => 'required|min:5|max:50',
            'last_name' => 'required|min:5|max:50',
            'email' => 'required|email|unique:users,email',
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

    public function createUser(UploadFileService $fileUploadService)
    {
        $validated = $this->validate();
        $validated['password'] = Hash::make($validated['password']);
        // dd( $fileUploadService->uploadFile($this->image));

        try {
            // Upload image file
            if ($this->image) {
                // $validated['image'] = $this->image->store('images');
                $validated['image'] = $fileUploadService->uploadFile($this->image);
            }
        } catch (Exception $e) {
            // Add error to 'image' field and log the exception
            $this->addError('image', 'File upload failed. Please try again.');
            \Log::error("File upload error: " . $e->getMessage());
            return; // Exit function to prevent user creation if upload fails
        }

        $user = User::create($validated);

        // Reset form fields and flash a message based on success or failure
        $this->reset(['first_name', 'last_name', 'email', 'phone', 'password', 'image']);
        session()->flash($user ? 'success' : 'error', $user ? 'User Created Successfully' : 'User Not Created');
    }


    public function render()
    {
        sleep(3);
        return view('livewire.index-component', [
            'isTemporaryFile' => $this->image instanceof TemporaryUploadedFile,
            'users' => User::paginate(8),
        ]);
    }
    public function deleteUser($id)
    {
        // sleep(1);
        User::destroy($id);
        // $this->resetPage();
        session()->flash('success', 'User Deleted Successfully');
    }
    public function editUser($id)
    {
        $user = User::find($id);
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->password = $user->password;
        $this->image = $user->image;
        $this->selectedUser_id = $user->id;
    }
    public function updateUser()
    {
        $validated = $this->validate();
        $validated['password'] = Hash::make($validated['password']);
        User::find($this->selectedUser_id)->update($validated);
        session()->flash('success', 'User Updated Successfully');
    }

    public function showUser($id)
    {
        // dd(vars: $id);
        $user = User::find($id);
        $this->showedUser_id = $user->id;
        $this->showedUser = User::find($this->showedUser_id);
        $this->dispatch('show-user');
    }



    // public function createUser(): void{
    //             $validated=$this->form->validate();
    //             // dd($validated);
    //             // Hash password manually
    //             $validated['password'] = Hash::make($this->password);

    //             // Create user
    //             $user = User::create(attributes: $validated);

    //             if ($user) {
    //                 session()->flash('success', 'User Created Successfully');
    //             } else {
    //                 session()->flash('error', 'User Not Created');
    //             }
    // }

}
