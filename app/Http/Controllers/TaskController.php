<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function index(){
        $tasks = Task::all();
        $users = User::all();
        return view('tasks.index', [
            'tasks'=> $tasks,
            'users'=> $users,
        ]);
    }

    public function addIndex(){
        return view('add-task', [
        ]);
    }

    public function store(Request $request){

        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->created_by = auth()->user()->id;
        $task->user_id = null;
        $task->estimation = $request->estimation;
        $task->effort = $request->effort;
        $task->start_date = $request->start_date;
        $task->save();
        activity('add task')->log(auth()->user()->name . ' added task ' . $task->name);

        return redirect()->route('task.list')->with('status', 'User created successfully!');
    }

    public function join($id)
    {
        $task = Task::find($id);
        $user = auth()->user();

        // Lấy chuỗi user_id hiện tại và chuyển thành mảng
        $currentUserIds = $task->user_id ? explode(',', $task->user_id) : [];

        // Kiểm tra nếu user chưa tồn tại trong task
        if (!in_array($user->id, $currentUserIds)) {
            // Thêm user_id mới vào mảng
            $currentUserIds[] = $user->id;
            // Chuyển mảng thành chuỗi và cập nhật task
            $task->user_id = implode(',', $currentUserIds);
            $task->save();
            activity('Join task')->log(auth()->user()->name . ' joined in ' . $task->name);

        }

        return redirect()->back()->with('success', 'Successfully joined the task');
    }

    public function updateIndex($id){
        $task = Task::find($id);
        $users = User::all();
        $userIds = explode(',', $task->user_id);
        $users2 = User::whereNotIn('id', $userIds)->get();
        return view('tasks.update-task', [
            'task'=> $task,
            'users'=> $users,
            'users2'=> $users2,
        ] );
    }
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $userIds = $request->user_ids;
        if($userIds == null) $task->user_id = null;
        else $task->user_id = implode(',', $userIds);
        $task->description = $request->description;
        $task->estimation = $request->estimation;
        $task->effort = $request->effort;
        $task->start_date = $request->start_date;
        $task->save();
        activity('update')->log(auth()->user()->name . ' updated ' . $task->name);

        return redirect()->route('task.list')
            ->with('success', 'User updated successfully!');

    }

    public function destroy($id)
    {

            $task = Task::find($id);
            $name = $task->name;
            $task->delete();
            activity('delete')->log(auth()->user()->name . ' deleted ' . $name);
            return redirect()->route('task.list')->with('success', 'User deleted successfully!');
    }


}
