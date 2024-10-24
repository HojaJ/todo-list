<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return response()->json([
            'status' => true,
            'message' => 'Todos retrieved successfully',
            'data' => $todos
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $todos = Todo::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Todo created successfully',
            'data' => $todos
        ], 201);
    }

    public function update(Request $request, Todo $todo)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $todo->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Todo updated successfully',
            'data' => $todo
        ], 200);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json([
            'status' => true,
            'message' => 'Todo deleted successfully'
        ], 204);
    }
}
