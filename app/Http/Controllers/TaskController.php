<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'status' => true,
            'tasks' => Task::orderBy('created_at', 'asc')->get()
        ],200);
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
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => false,
                'reason' => $validator->errors()
            ],200);
        }

        $task = new Task;
        $task->name = $request->get('name');
        $task->save();

        return response([
            'status' => true,
            'task_details' => $task
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($taskId)
    {
        $task = Task::find($taskId);
        if($task){
            return response([
                'status' => true,
                'task_details' => $task
            ],200);
        }else{
            return response([
                'status' => false,
                'reason' => 'invalid task details'
            ],200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $taskId)
    {
        $task = Task::where('id',$taskId)->first();
        if(!$task){
            return response([
                'status' => false,
                'reason' => 'invalid task details'
            ],200);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => false,
                'reason' => $validator->errors()->messages()
            ],200);
        }
        Task::where('id',$taskId)->update(array(
            'name' => $request->get('name')
        ));
        return response([
            'status' => true,
            'response' => 'Updated Successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($taskId)
    {
        $task = Task::where('id',$taskId)->first();
        if(!$task){
            return response([
                'status' => false,
                'reason' => 'invalid task details'
            ],200);
        }
        Task::where('id',$taskId)->delete();
        return response([
            'status' => true,
            'response' => 'Deleted Successfully'
        ],200);
    }
}
