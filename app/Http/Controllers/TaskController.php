<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::query();

        if ($request->has('status')) {
            $tasks->where('status', $request->status);
        }

        if ($request->has('date')) {
            $tasks->whereDate('due_date', $request->date);
        }

        if ($request->has('user_id')) {
            $tasks->where('user_id', $request->user_id);
        }

        // if ($request->has('user_id')) {
        //     $tasks->whereHas('users', function ($query) use ($request) {
        //         $query->where('user_id', $request->user_id);
        //     });
        // }

        return response()->json($tasks->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $task = Task::create($request->all());
        return response()->json($task, 201);

        // $task = Task::create($request->all());
        // return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'due_date' => 'sometimes|required|date',
            'status' => ['sometimes', 'required', Rule::in(['pending', 'in_progress', 'completed'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $task = Task::findOrFail($id);
        $task->update($request->all());

        // Return response
        return response()->json($task, 200);
        // $task = Task::findOrFail($id);
        // $task->update($request->all());
        // return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(null, 204);
    }



    public function assignUser(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->users()->attach($request->user_id);
        return response()->json($task->load('users'), 200);
    }


    public function unassignUser(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->users()->detach($request->user_id);

        return response()->json($task->load('users'), 200);
    }

    public function changeStatus(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->update(['status' => $request->status]);
        return response()->json($task, 200);
    }



    public function tasksForUser($userId)
    {
        $user = User::findOrFail($userId);
        $tasks = $user->tasks()->get();
        return response()->json($tasks, 200);
    }

    public function tasksForCurrentUser(Request $request)
    {
        $user = $request->user();
        $tasks = $user->tasks()->get();

        return response()->json($tasks, 200);
    }
}
