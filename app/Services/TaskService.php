<?php

namespace App\Services;

use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Log;

class TaskService
{

    protected $model;
    public function __construct(Task $task)
    {

        $this->model = $task;
    }
    public function create($params)
    {
        try {

            return $this->model->create($params);
        } catch (\Exception $exception) {
            Log::error(massage: $exception);

            return false;
        }
    }
    public function update($task, $param)
    {
        $param['status'] = 100;
        return $task->update($param);
    }

    public function findId($id)
    {
        return Task::find($id);
    }

    public function softDelete($task)
    {
        return $task->delete();
    }


    public function findIdSoftDelete($id)
    {
        return Task::withTrashed()->where("id", $id)->first();
    }

    public function restore($task)
    {
        return $task->restore();
    }


    public function pagination($limit)
    {
        return Task::select("name", "description", "status")
            ->paginate($limit);
    }
}
