<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        h1 {
            color: #007bff;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
        }

        .btn-primary,
        .btn-warning,
        .btn-danger {
            border-radius: 20px;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-footer .btn-secondary {
            background-color: #6c757d;
        }

        .modal-footer .btn-primary {
            background-color: #28a745;
        }

        .alert {
            margin-bottom: 20px;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .form-control {
            border-radius: 10px;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .search-container input {
            width: 50%;
            padding: 8px;
            font-size: 14px;
            border-radius: 25px;
            border: 1px solid #ced4da;
        }

        .search-container input:focus {
            outline: none;
            border-color: #007bff;
        }

        .btn-close {
            border-radius: 50%;
        }

        .add-todo-btn-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Todo List</h1>

        {{-- Display Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Display Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="search" placeholder="Search Todos...">
        </div>

        <!-- Centered Add Todo Button -->
        <div class="add-todo-btn-container">
            <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal"
                data-bs-target="#todoInsertModal">
                Add Todo
            </button>
        </div>

        <!-- Todo Table -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $todo)
                    <tr>
                        <td>{{ $todo->id }}</td>
                        <td>{{ $todo->subject }}</td>
                        <td>{{ $todo->description }}</td>
                        <td>
                            <button data-id="{{ $todo->id }}" data-subject="{{ $todo->subject }}"
                                data-description="{{ $todo->description }}" type="button"
                                class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#todoUpdateModal">
                                Update Todo
                            </button>
                            <form method="POST" action="{{ url('delete/' . $todo->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm ms-2">Delete Todo</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Insert Modal -->
    <div class="modal fade" id="todoInsertModal" tabindex="-1" aria-labelledby="todoInsertModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="todoInsertModalLabel">Add Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('insert') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="insertSubject" class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" id="insertSubject" required>
                        </div>
                        <div class="mb-3">
                            <label for="insertDescription" class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" id="insertDescription"
                                required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Todo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="todoUpdateModal" tabindex="-1" aria-labelledby="todoUpdateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="todoUpdateModalLabel">Update Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('update') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="updateSubject" class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" id="updateSubject" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateDescription" class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" id="updateDescription"
                                required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Todo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Modal Setup for Update
            $('[data-bs-toggle="modal"][data-bs-target="#todoUpdateModal"]').on('click', function() {
                let subject = $(this).data('subject');
                let description = $(this).data('description');
                let id = $(this).data('id');

                $('#todoUpdateModal input[name="subject"]').val(subject);
                $('#todoUpdateModal input[name="description"]').val(description);
                
                $('#todoUpdateModal form').attr('action', '/update/' + id);
            });

            // Debounce Search
            let debounceTimer;
            $('#search').on('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    let searchQuery = $(this).val();
                    $.ajax({
                        url: '/search',
                        method: 'GET',
                        data: {
                            search: searchQuery
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('tbody').html(response);

                            $('[data-bs-toggle="modal"][data-bs-target="#todoUpdateModal"]')
                                .on('click', function() {
                                    let subject = $(this).data('subject');
                                    let description = $(this).data('description');
                                    let id = $(this).data('id');

                                    $('#todoUpdateModal input[name="subject"]').val(
                                        subject);
                                    $('#todoUpdateModal input[name="description"]')
                                        .val(description);
                                    $('#todoUpdateModal form').attr('action',
                                        '/update/' + id);
                                });
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error: ' + status + ' ' + error);
                        }
                    });
                }, 300);
            });
        });
    </script>
</body>

</html>
