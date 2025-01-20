<div class="container" x-data="userModal()">
    <h1 x-data="{ message: 'I ❤️ Alpine' }" x-text="message"></h1>
    <!-- Session Messages -->
    <div>
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @elseif(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- User Table -->
    <h2>Users</h2>
    <div class="table-responsive">
        <table class="table table-striped">
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
                            @if ($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Image Preview" width="80">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" @click="editUser({{ $user->id }})">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm" wire:click="deleteUser({{ $user->id }})">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $users->links() }}
    </div>

    <!-- Edit Modal -->
    <template x-if="isOpen">
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updateUser">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" class="form-control" wire:model="first_name">
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" class="form-control" wire:model="last_name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" wire:model="email">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" class="form-control" wire:model="phone">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
                        <button type="submit" class="btn btn-primary" @click="closeModal" wire:click="updateUser">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function userModal() {
        return {
            isOpen: false,
            editUser(userId) {
                this.isOpen = true;
                @this.call('editUser', userId); // Call Livewire method to load user data
            },
            closeModal() {
                this.isOpen = false;
            }
        }
    }
</script>
