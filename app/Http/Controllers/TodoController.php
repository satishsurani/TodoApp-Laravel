<?php

namespace App\Http\Controllers;

use App\Models\todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('displayTodo', ['data' => $todos]);
    }

    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'subject' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        // Store the new todo
        $todo = new Todo();
        $todo->subject = $validatedData['subject'];
        $todo->description = $validatedData['description'];

        if ($todo->save()) {
            return redirect()->route('index')->with('success', 'Todo added successfully.');
        } else {
            return back()->with('error', 'Error while inserting todo.');
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the input
        $validatedData = $request->validate([
            'subject' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        // Find the todo item
        $todo = Todo::find($id);

        if ($todo) {
            // Update the todo item
            $todo->subject = $validatedData['subject'];
            $todo->description = $validatedData['description'];

            if ($todo->save()) {
                return redirect()->route('index')->with('success', 'Todo updated successfully.');
            } else {
                return back()->with('error', 'Error while updating todo.');
            }
        } else {
            return back()->with('error', 'Todo not found.');
        }
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);

        if ($todo) {
            // Delete the todo
            if ($todo->delete()) {
                return redirect()->route('index')->with('success', 'Todo deleted successfully.');
            } else {
                return back()->with('error', 'Error while deleting todo.');
            }
        } else {
            return back()->with('error', 'Todo not found.');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $todos = Todo::query()
            ->where('subject', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->get();

        return response()->json($this->renderTodosTable($todos));
    }

    private function renderTodosTable($todos)
    {
        $todoHtml = '';
        foreach ($todos as $todo) {
            $todoHtml .= view('partials.todo-row', compact('todo'))->render();
        }
        return $todoHtml;
    }
}
