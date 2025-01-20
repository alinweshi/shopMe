<div class="container">
    <div>
        @if(session()->has('error'))
        {{ session('error') }}
        @elseif(session()->has('success'))
        <div wire:loading.delay.longest>
            {{ session('success') }}
        </div> <!-- 200ms -->
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
        <form id="form" wire:submit.prevent="updateUser">
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
                    <div wire:loading.inline-flex>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"
                            width="50">in progress.</div>
                </div>
                {{-- <div>
                    <div wire:loading.inline>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"
                            width="50">in progress.</div>
                </div>
                <div>
                    <div wire:loading.flex>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"
                            width="50">in progress.</div>
                </div>
                <div>
                    <div wire:loading.block>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"
                            width="50">in progress.</div>
                </div>
                <div>
                    <div wire:loading.table>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"
                            width="50">in progress.</div>
                </div>
                <div>
                    <div wire:loading.grid>Loading data <img src="{{ asset('images/5.png') }}" alt="Loading"
                            width="50">in progress.</div>
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
                    @elseif($selectedUser && $image)
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
                @if($selectedUser)
                <button class="btn btn-primary" wire:loading.class.remove="btn btn-primary" wire:target='updateUser'>
                    Update User
                </button>
                {{-- @else --}}
                {{-- <button class="btn btn-primary" wire:loading.class.remove="btn btn-danger"
                    wire:target='createUser'>
                    Create User
                </button> --}}
                @endif
                    <button class="btn btn-primary" wire:click.prevent="cancel">
                        Cancel
                    </button>
            </div>
        </form>

    </div>
</div>
