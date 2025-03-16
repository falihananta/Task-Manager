<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        Task::create($validated);

        Session::flash('success', 'Tugas berhasil ditambahkan!');
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified task.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task->update($validated);

        Session::flash('success', 'Tugas berhasil diperbarui!');
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        
        Session::flash('success', 'Tugas berhasil dihapus!');
        return redirect()->route('tasks.index');
    }
    
    /**
     * Delete task with AJAX
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteAjax(Request $request)
    {
        $taskId = $request->input('task_id');
        $task = Task::findOrFail($taskId);
        $task->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus!'
        ]);
    }
    
    /**
     * Toggle task completion status
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggleComplete(Request $request)
    {
        $taskId = $request->input('task_id');
        $task = Task::findOrFail($taskId);
        
        $task->is_completed = !$task->is_completed;
        $task->save();
        
        return response()->json([
            'success' => true,
            'is_completed' => $task->is_completed,
            'message' => $task->is_completed ? 'Tugas ditandai selesai!' : 'Tugas ditandai belum selesai!'
        ]);
    }
}