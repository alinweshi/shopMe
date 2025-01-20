<style>
    .container {
        width: 100%;
        height: 100vh;
        background-color: #f2f2f2;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .todo-form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .form-group {
        width: 400px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 0px 10px 0px #0000001a;
        padding: 20px;
        margin: 20px;
    }

    .form-label {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin: 10px 0px;
        display: block;
    }

    #btn {
        position: relative;
        font-size: 20px;
        padding: 10px 20px;
        background-color: #fff;
        border: 2px solid black;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        display: inline-block;
        margin-top: 20px;
    }

    #btn:hover {
        background-color: #0056b3;
        color: #fff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border: 2px solid #000000;
        transition: 0.5s ease-in-out;
    }
</style>

<div class="container">
    @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
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
    @if (session()->has('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif
<div class="todo-form">
    <form wire:submit.prevent="save">
        <div class="form-group">
            <div>
                <label class="form-label" for="title">Title</label>
                <input type="text" wire:model="title" id="title" required>
            </div>
        </div>
        <div class="form-group">
            <div>
                <label class="form-label" for="description">Description</label>
                <textarea wire:model="description" id="description" required></textarea>
            </div>
        </div>
        <button  id="btn">createTodoList</button>
    </form>
</div>

    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todos as $todo)
                <tr>
                    <td>{{ $todo->title }}</td>
                    <td>{{ $todo->description }}</td>
                    <td>
                        <button wire:click="edit({{ $todo->id }})">Edit</button>
                        <button wire:click="delete({{ $todo->id }})">Delete</button>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
