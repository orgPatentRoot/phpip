<?php

namespace App\Http\Controllers;

use App\Task;
//use App\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $task = new Task;
        $isrenewals = $request->isrenewals;
        $nrecords = 100;
        if ($isrenewals) {
          $nrecords = 200;
        }
        $tasks = $task->openTasks($isrenewals, $request->what_tasks, $request->user_dashboard)->take($nrecords)->get();
        return view('task.index', compact('tasks', 'isrenewals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'trigger_id' => 'required|numeric',
            'due_date' => 'required',
            'cost' => 'nullable|numeric',
            'fee' => 'nullable|numeric'
        ]);
        $request->merge([ 'creator' => Auth::user()->login ]);
        return Task::create($request->except(['_token', '_method']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'due_date' => 'sometimes',
            'cost' => 'nullable|numeric',
            'fee' => 'nullable|numeric'
        ]);
        $request->merge([ 'updater' => Auth::user()->login ]);
        // Remove task rule when due date is manually changed
        if ($request->has('due_date')) {
            $request->merge(['rule_used' => null]);
        }

        $task->update($request->except(['_token', '_method']));
        return response()->json(['success' => 'Task updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['success' => 'Task deleted']);
    }
}
