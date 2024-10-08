<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\CreateRequest;
use App\Http\Requests\Api\Task\UpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    protected $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return response()->json(['message' => 'Hello World!']);
    }


    public function store(CreateRequest $createRequest)
    {
        $request = $createRequest->validated();
        $result = $this->taskService->create($request);

        if ($result) {
            return new TaskResource($result);
        }
        return response()->json([
            'message' => 'error'
        ]);
    }
    public function show(Task $task)
    {
        return new TaskResource($task);
    }
    public function update(Task $task, UpdateRequest $updateRequest)
    {
        // Lấy dữ liệu đã được xác thực
        $request = $updateRequest->validated();

        // Gọi đến service để cập nhật task

        $result = $this->taskService->update($task, $request);
        if ($result) {

            return response()->json([
                'message' => 'cap nhat thanh cong'
            ]); // Trả về dữ liệu sau khi cập nhật thành công
        }

        return response()->json([
            'message' => 'cap nhat loi'
        ]);
    }

    // Phương thức xóa mềm
    public function delete($id): JsonResponse
    {
        $task = $this->taskService->findId($id);

        if (!$task) {
            return response()->json(['message' => 'Dữ liệu không tồn tại'], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $result = $this->taskService->softDelete($task);

        if ($result) {
            return response()->json(['message' => 'Xoá dữ liệu thành công'], 200, [], JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['message' => 'Xoá dữ liệu không thành công'], 200, [], JSON_UNESCAPED_UNICODE);
    }


    public function restore($id)
    {
        $task = $this->taskService->findIdSoftDelete($id);

        $result = $this->taskService->restore($task);
        if ($result) {
            return response()->json(['message' => 'Khôi phục dữ liệu thành công'], 200, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json(['message' => 'Khôi phục dữ liệu không thành công'], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
