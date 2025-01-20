<div class="container">
    <h1 x-data="{ message: 'I ❤️ Alpine' }" x-text="message"></h1>

    <div>
        @if(session()->has('error'))
        {{ session('error') }}
        @elseif(session()->has('success'))
        <div class="alert alert-success">
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
        {{ $this->getUsers->count() }} users found
    </div>
    <div class="input-group mb-3">
            {{-- <input type="text" class="form-control" id='search' wire:model.live='search' placeholder="search"> --}}
            {{-- <input type="text" class="form-control" id='search' wire:model.blur='search' placeholder="search" wire:dirty.class="border-yellow"> --}}
            {{-- <input type="text" class="form-control" id='search' wire:model.live.debounce.1000ms='search' placeholder="search"> --}}
            <input type="text" class="form-control" id='search' wire:model.throttle.1000ms='search' placeholder="search">
            {{-- <input type="text" class="form-control" id='search' wire:model.live='search' placeholder="search"> --}}
    </div>
    <div>
        <button class="btn btn-primary" wire:click="searchUser">Search</button>
        <button class="btn btn-danger" wire:click="clearSearch">Clear</button>
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
                            <a class="btn btn-primary" href="{{ route('user.update', ['user' => $user->id]) }}">
                                Edit
                            </a>

                            {{-- <button class="btn btn-primary" wire:click="editUser({{ $user->id }})"
                                wire:loading.attr="disabled">
                                Edit
                            </button> --}}
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    {{-- <div class="pagination" wire:poll> --}}
        {{-- <div class="pagination" wire:poll.15s> --}}
            {{-- <div wire:poll.visible> --}}

                <div wire:poll.keep-alive>
                    {{ $users->links() }}
                </div>

            </div>
        </div>

    </div>
</div>
