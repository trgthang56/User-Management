<?php

namespace App\Http\Controllers;

use App\Events\CheckTaskStatus;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    //
    public function index(){
        // \Artisan::call('task:check-status');
        event(new CheckTaskStatus());
        $keyword = request()->get('keyword');
        if($keyword){
            $tasks = $this->taskService->getTasksWithFilter($keyword);
        }else{
            $tasks = $this->taskService->getTasks();

        }
        return view('tasks.index', [
            'tasks'=> $tasks,
            'users'=> $this->taskService->getUsers(),
        ]);
    }

    public function store(Request $request){
        $this->taskService->createTask($request->all());
        return redirect()->route('task.list')->with('success', 'task created successfully!');
    }

    public function join($id)
    {
        $this->taskService->joinTask($id);
        return redirect()->back()->with('success', 'Successfully joined the task');
    }

    public function updateIndex($id){
        $task = $this->taskService->getTaskById($id);
        $users = $this->taskService->getUsers();
        $users2 = $this->taskService->getUsers2($id);
        return view('tasks.edit', [
            'task'=> $task,
            'users'=> $users,
            'users2'=> $users2,
        ] );
    }

    public function detail($id){
        $task = $this->taskService->getTaskById($id);
        $users = $this->taskService->getUsers();
        $users2 = $this->taskService->getUsers2($id);
        return view('tasks.detail', [
            'task'=> $task,
            'users'=> $users,
            'users2'=> $users2,
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->taskService->updateTask($request, $id);
        return redirect()->route('task.list')->with('success', 'Task updated successfully!');

    }

    public function destroy($id)
    {
        $this->taskService->destroyTask($id);
        return redirect()->route('task.list')->with('success', 'Task deleted successfully!');
    }

    public function destroySelected(Request $request)
    {
        $this->taskService->destroySelectedTasks($request);
        return redirect()->route('task.list')->with('success', 'Tasks deleted successfully!');
    }


}
