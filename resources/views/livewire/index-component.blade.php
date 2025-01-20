<div class="container">
    <div>
        @if(session()->has('error'))
        {{ session('error') }}
        @elseif(session()->has('success'))
        <div >
                    {{ session('success') }}
        </div>          <!-- 200ms -->
        @elseif(session()->has('message'))
        {{ session('message') }}
        @endif
    </div>
    <div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div>
        <form id="form" wire:submit.prevent="{{ $selectedUser_id ? 'updateUser' : 'createUser' }}">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input class="form-control" type="text" wire:model="first_name" value="{{ old('first_name','') }}">
                <div>@error('first_name') {{ $message }} @enderror</div>

            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input class="form-control" type="text" wire:model="last_name" value="{{ old('last_name','') }}">
                <div>@error('last_name') {{ $message }} @enderror</div>

            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" wire:model="email" value="{{ old('email','') }}">
                <div>@error('email') {{ $message }} @enderror</div>

            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input class="form-control" type="text" wire:model="phone" value="{{ old('phone','') }}">
                <div>@error('phone') {{ $message }} @enderror</div>
                <div>
                    {{-- Loading data <div wire:loading.inline><img src="loading-spinner.gif" alt="Loading"></div> in
                    progress. --}}
                </div>
                <div>
                    <div wire:loading.inline-flex>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"  width="50">in progress.</div>
                </div>
                {{-- <div>
                    <div wire:loading.inline>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"  width="50">in progress.</div>
                </div>
                <div>
                    <div wire:loading.flex>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"  width="50">in progress.</div>
                </div>
                <div>
                    <div wire:loading.block>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"  width="50">in progress.</div>
                </div>
                <div>
                    <div wire:loading.table>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"  width="50">in progress.</div>
                </div>
                <div>
                    <div wire:loading.grid>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"  width="50">in progress.</div>
                </div> --}}
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input class="form-control" type="password" wire:model="password" value="{{ old('password','') }}">
                <div>@error('password') {{ $message }} @enderror</div>
                <div wire:loading.remove>
                    <span> Generating password</span>
                </div>

            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Large file input example</label>
                <input class="form-control form-control-lg" id="image" type="file" wire:model="image" accept="image/*">
                <div>@error('image') {{ $message }} @enderror</div>
                <div class="mt-3">
                    @if($isTemporaryFile)
                    <img src="{{ $image->temporaryUrl() }}" alt="Image Preview" width="100">
                    @elseif($selectedUser_id && $image)
                    {{-- Show the stored image path for editing --}}
                    <img src="{{ asset('storage/' . $image) }}" alt="Image Preview" width="100">
                    @endif
                </div>

                <div class="mt-3" wire:loading wire:target='image'>
                    <span> uploading </span>
                </div>

            </div>
            <div class="mb-3">
                {{-- <button wire:loading.class="opacity-50">CreateUser</button> --}}
                @if($selectedUser_id)
                <button class="btn btn-primary" wire:loading.class.remove="btn btn-primary" wire:target='updateUser'>
                    Update User
                </button>
                @else
                {{-- <button class="btn btn-primary" wire:loading.class.remove="btn btn-danger" wire:target='createUser'>
                    Create User
                </button> --}}
                <button class="btn btn-primary" wire:loading.class="btn btn-danger" wire:target='createUser'>
                    Create User
                </button>
                {{-- <button class="btn btn-primary" wire:loading.remove wire:target='createUser'>
                    Create User
                </button> --}}
                @endif
            </div>
        </form>
    </div>
    <div>
        <h2>Users</h2>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @if ($user->image )
                            <img src="{{ asset('storage/' . $user->image) }}" alt="Image Preview" width="100">
                            @else
                            <span>No Image</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-danger" wire:click="deleteUser({{ $user->id }})"
                                wire:loading.attr="disabled">
                                Delete
                            </button>
                            <button class="btn btn-primary" wire:click="editUser({{ $user->id }})"
                                wire:loading.attr="disabled">
                                Edit
                            </button>
                            <button class="btn btn-secondary" wire:click="showUser({{ $user->id }})"
                                wire:loading.attr="disabled">
                                Show
                            </button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination">
        {{ $users->links() }}
    </div>
    <div>
        <h3>User Information</h3>
        @if($showedUser_id&&$showedUser)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $showedUser->id }}</td>
                            <td>{{ $showedUser->first_name }}</td>
                            <td>{{ $showedUser->last_name }}</td>
                            <td>{{ $showedUser->email }}</td>
                            <td>{{ $showedUser->phone }}</td>
                            <td>
                                <button class="btn btn-primary" wire:click="editUser({{ $showedUser->id }})" wire:loading.attr="disabled">
                                    Edit
                                </button>
                                <button class="btn btn-danger" wire:click="deleteUser({{ $showedUser->id }})" wire:loading.attr="disabled">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
                <p>No user found.</p>
            @endif
    </div>


</div>
</div>
