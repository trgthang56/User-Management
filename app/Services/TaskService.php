<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getTasks()
    {
        return $this->taskRepository->getTasks();
    }

    public function getTasksWithFilter($keyword)
    {
        return $this->taskRepository->getTasksWithFilter($keyword);
    }

    public function getUsers()
    {
        return $this->taskRepository->getUsers();
    }

    public function getUsers2($id){
        $task = $this->taskRepository->findTask($id);
        $userIds = explode(',', $task->user_id);
        return $this->taskRepository->getUsers()->whereNotIn('id', $userIds);
    }

    public function getTaskById($id){
        return $this->taskRepository->findTask($id);
    }

    public function createTask($data){
        if ($data['start_date'] == null) {
            $data['start_date'] = now();
            $endDate = (clone $data['start_date'])->addHours((int)$data['effort']);
            $data['end_date'] = $endDate->format('Y-m-d H:i:s');
            $data['start_date'] = $data['start_date']->format('Y-m-d H:i:s');
        } else {
            $startDate = \Carbon\Carbon::parse($data['start_date']);
            $endDate = (clone $startDate)->addHours((int)$data['effort']);
            $data['end_date'] = $endDate->format('Y-m-d H:i:s');
            $data['start_date'] = $startDate->format('Y-m-d H:i:s');
        }
        $data['status'] = '0';
        $data['created_by'] = auth()->user()->id;

        activity('add task')->log(auth()->user()->name . ' added task ' . $data['name']);
        return $this->taskRepository->createTask($data);
    }

    public function joinTask($id){
        $task = $this->taskRepository->findTask($id);

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
        activity('join task')->log(auth()->user()->name . ' joined task ' . $task->name);
        return $task;
    }

    public function updateTask($request, $id){
        $task = $this->taskRepository->findTask($id);
        $userIds = $request->user_ids;
        if($userIds == null) $task->user_id = null;
        else $task->user_id = implode(',', $userIds);
        $task->description = $request->description;
        $task->estimation = $request->estimation;
        $task->effort = $request->effort;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = (clone $startDate)->addHours((int)$request->effort);
        $request->end_date = $endDate->format('Y-m-d H:i:s');
        $request->start_date = $startDate->format('Y-m-d H:i:s');
        $task->save();
        activity('update task')->log(auth()->user()->name . ' updated task ' . $task->name);
        return $task;
    }

    public function destroyTask($id){
        $task = $this->taskRepository->findTask($id);
        $name = $task->name;
        $task->delete();
        activity('delete task')->log(auth()->user()->name . ' deleted task ' . $name);
        return $task;
    }

    public function destroySelectedTasks($request){
        $ids = json_decode($request->selected_ids);
        $taskNames = [];
        foreach($ids as $id){
            $task = $this->taskRepository->findTask($id);
            $name = $task->name;
             // Initialize an empty array to store task names
            $taskNames[] = $name; // Add the current task name to the array
            $task->delete();

        }
        activity('delete task')->log(auth()->user()->name . ' deleted tasks ' . implode(', ', $taskNames));
        return $task;
    }




}