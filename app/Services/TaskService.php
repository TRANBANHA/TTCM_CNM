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
    public function update(Task $task, array $data)
    {

        try {

            $task->update($data);
            return $task;
        } catch (\Exception $e) {
            return false;
        }
    }
}
