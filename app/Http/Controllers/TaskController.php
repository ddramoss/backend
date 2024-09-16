<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Mail\HighPriorityTaskMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * index: Obtiene todas las tareas
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = Task::where('user_id', Auth::id())
        ->when(isset($request->title), function($query) use ($request){
            return $query->where('title', 'like', "%$request->title%");
        })
        ->when(isset($request->description), function($query) use ($request){
            $query->where('description', 'like', "%$request->description%");
        })
        ->when(isset($request->due_date), function($query) use ($request){
            $query->whereDate('due_date', '=', $request->due_date);
        })
        ->when(isset($request->status), function($query) use ($request){
            $query->where('status', $request->status);
        })
        ->when(isset($request->priority), function($query) use ($request){
            $query->where('priority', $request->priority);
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(5);

        return response()->json([
            'data' => $tasks->items(), // Tareas actuales
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ]
        ]);
    }

    /**
     * store: Crear nueva tarea
     *
     * @param  TaskRequest $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request): JsonResponse
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'user_id' => Auth::id(),
            'status' => $request->status,
            'priority' => $request->priority,

        ]);

        $this->checkHighPriorityTask($task);

        return response()->json($task, 201);
    }

    /**
     * update: Actualizar tarea
     *
     * @param  TaskRequest $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(TaskRequest $request, int $id): JsonResponse
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id); // Encuentra la tarea del usuario autenticado

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'priority' => $request->priority,
        ]);

        $this->checkHighPriorityTask($task);

        return response()->json($task);
    }

    /**
     * checkHighPriorityTask: Verifica la prioridad de la tarea, si es "Alta" envía correo.
     *
     * @param  Task $task
     * @return void
     */
    private function checkHighPriorityTask(Task $task): void
    {
        if ($task->priority === 'Alta') {
            $user = Auth::user();
            Mail::to($user->email)->send(new HighPriorityTaskMail($task, $user));
        }
    }

    /**
     * destroy: Eliminar tarea
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id); // Encuentra la tarea del usuario autenticado

        $task->delete();

        return response()->json(null, 204);
    }
}
