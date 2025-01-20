<div>

    <h2>User Information</h2>

    @if($user)
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
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    <button class="btn btn-primary" wire:click="editUser" wire:loading.attr="disabled">
                        Edit
                    </button>
                    <button class="btn btn-danger" wire:click="deleteUser" wire:loading.attr="disabled">
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
