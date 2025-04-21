<?php
namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TaskRepository
{
    protected $task;
    protected $user;

    public function __construct(Task $task, User $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    public function getTasks()
    {
        return $this->task->orderBy('status', 'desc')->paginate(10);
    }

    public function getUsers()
    {
        return $this->user->all();
    }

    public function getTasksWithFilter($keyword)
    {
        return $this->task->where('status', $keyword)->paginate(10);
    }

    public function createTask(array $data)
    {
        return $this->task->create($data);
    }

    public function updateTask($id, array $validated)
    {
        $task = $this->task->find($id);
        $task->update($validated);
        return $task;
    }
    public function findTask($id)
    {
        return $this->task->find($id);
    }
    public function deleteTask($id)
    {
        return $this->task->destroy($id);
    }
}