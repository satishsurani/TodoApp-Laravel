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
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #3A5A40;
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }

        .btn-primary,
        .btn-warning,
        .btn-danger {
            border-radius: 50px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-warning:hover {
            background-color: #e08e2c;
        }

        .btn-danger:hover {
            background-color: #e02727;
        }

        .modal-header {
            background-color: #28a745;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .modal-footer .btn-secondary {
            background-color: #6c757d;
        }

        .modal-footer .btn-primary {
            background-color: #28a745;
        }

        .alert {
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 15px;
        }

        .form-control {
            border-radius: 10px;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            width: 100%;
        }

        .search-container input {
            width: 60%;
            padding: 10px;
            font-size: 16px;
            border-radius: 25px;
            border: 1px solid #ced4da;
            transition: border 0.3s;
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
            width: 100%;
        }

        table {
            width: 100%;
            margin-bottom: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .modal-content {
            border-radius: 10px;
        }

        .custom-pagination {
            margin: 0 2px;
            justify-content: center;
        }

        .custom-pagination .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .custom-pagination div {
            flex-direction: column;
        }
        
        .pagination li {
            margin: 5px;
        }

        .pagination li.active a {
            background-color: #28a745;
            color: white;
        }

        .table td input[type="checkbox"] {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }


        /* Responsive adjustments */
        @media (max-width: 768px) {
            .search-container input {
                width: 80%;
            }

            .table th,
            .table td {
                padding: 10px;
            }

            .add-todo-btn-container {
                width: 100%;
            }
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#todoInsertModal">
                Add Todo
            </button>
        </div>
        <form action="{{ url('deleteMultiple') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mb-4" id="deleteSelectedButton" disabled>Delete Selected
                Todos</button>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $todo)
                        <tr>
                            <td>
                                <input type="checkbox" class="todo-checkbox" name="ids[]"
                                    value="{{ $todo->id }}" />
                            </td>
                            <td>{{ $todo->subject }}</td>
                            <td>{{ $todo->description }}</td>
                            <td>
                                <button data-id="{{ $todo->id }}" data-subject="{{ $todo->subject }}"
                                    data-description="{{ $todo->description }}" type="button"
                                    class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#todoUpdateModal">
                                    Update Todo
                                </button>
                                <form method="POST" action="{{ url('delete/' . $todo->id) }}"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm ms-2">Delete Todo</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>

        <!-- Pagination -->
        <div class="d-flex custom-pagination">
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
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
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error: ' + status + ' ' + error);
                        }
                    });
                }, 300);
            });

            // Enable/Disable delete button based on checkbox selection
            $('.todo-checkbox').on('change', function() {
                let selectedTodos = $('.todo-checkbox:checked').length;
                if (selectedTodos > 0) {
                    $('#deleteSelectedButton').prop('disabled', false);
                } else {
                    $('#deleteSelectedButton').prop('disabled', true);
                }
            });
        });
    </script>
</body>

</html>
