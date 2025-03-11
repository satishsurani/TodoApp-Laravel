<tr>
    <th><input type="checkbox" class="todo-checkbox" name="ids[]" value="{{ $todo->id }}" /></th>
    <td>{{ $todo->subject }}</td>
    <td>{{ $todo->description }}</td>
    <td>
        <button data-id="{{ $todo->id }}" data-subject="{{ $todo->subject }}"
            data-description="{{ $todo->description }}" type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
            data-bs-target="#todoUpdateModal">
            Update Todo
        </button>
        <form method="POST" action="{{ url('delete/' . $todo->id) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete Todo</button>
        </form>
    </td>
</tr>