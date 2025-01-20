<div>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #eaeaea;
        }

        .container {
            width: 100%;
            min-height: 100vh;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
            padding: 20px;
            overflow-y: auto;
        }

        .search {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            align-content: center;
        }

        .task-form {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            align-content: center;
        }

        .form-group {
            width: 400px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px 0;
        }

        .form-label {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 5px;
        }

        #btn,
        #cancelEdit {
            font-size: 18px;
            padding: 10px 20px;
            background-color: #4CAF50;
            /* Green */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            margin: 10px 5px;
        }

        #btn:hover,
        #cancelEdit:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .table {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .task-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .task-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .task-description {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .small-btn {
            font-size: 14px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .small-btn.edit {
            background-color: #007BFF;
            /* Blue */
        }

        .small-btn.delete {
            background-color: #dc3545;
            /* Red */
        }

        .small-btn.edit:hover {
            background-color: #0056b3;
        }

        .small-btn.delete:hover {
            background-color: #c82333;
        }

        .pagination {
            padding-top: 20px;
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .alert {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            max-width: 600px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .error {
            margin-top: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .date {
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>

    <div class="container">
        <div class="error">
            @foreach (['success', 'error', 'message'] as $msg)
            @if (session()->has($msg))
            <div class="alert alert-{{ $msg == 'error' ? 'danger' : 'success' }}">
                {{ session($msg) }}
            </div>
            @endif
            @endforeach

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

        <div class="search">
            <input type="text" wire:model.live="search" placeholder="Search"
                style="padding: 10px; border-radius: 5px; border: 1px solid #ddd; width: 400px;">
        </div>

        <div class="task-form">
            <form wire:submit.prevent="{{ $selectedTaskId ? 'update' : 'save' }}">
                <div class="form-group">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" wire:model="title" id="title" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea wire:model="description" id="description" required></textarea>
                </div>
                <div>
                    <button id="btn">{{ $selectedTaskId ? 'Update Task' : 'Create Task' }}</button>
                    @if($selectedTaskId)
                    <button id="cancelEdit" type="button" wire:click="cancelEdit">Cancel</button>
                    @endif
                </div>
            </form>
        </div>

        <div class="table">
            @foreach($tasks as $task)
            <div class="task-card">
                <div class="task-title">{{ $task->title }}</div>
                <div class="task-description">{{ $task->description }}</div>
                <div class="date">{{ $task->created_at->format('d/m/Y H:i:s')}}</div>
                <div class="small-btn">
                    <button class="small-btn edit" wire:click="edit({{ $task->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil" viewBox="0 0 16 16">
                            <path
                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                        </svg>
                     </button>
                    <button class="small-btn delete" wire:click="delete({{ $task->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                    </button>
                </div>

            </div>
            @endforeach
        </div>
        <div class="pagination">
            {{ $tasks->links() }}
        </div>
    </div>
</div>
