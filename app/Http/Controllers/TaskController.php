<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;

class TaskController extends Controller
{
    // 一覧表示
    public function index(int $id){
        // Folderモデルのallクラスメソッドですべて取得
        $folders = Folder::all();

        // 選択されたフォルダを取得
        $current_folder = Folder::find($id);

        // 選択されたフォルダに紐づくタスクを取得
//        $tasks = Task::where('folder_id', $current_folder->id)->get();
        $tasks = $current_folder->tasks()->get();

        // 'folders'がキー、$foldersが代入値
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);
    }

    // タスク作成画面表示(use CreateTaskは必要ない)
    public function showCreateForm(int $id){
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    // タスク作成（use CreateTaskが必要。requestのため）
    public function create(int $id, CreateTask $request){
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    public function showEditForm(int $id, int $task_id){
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    public function edit(int $id, int $task_id, EditTask $request){
        // 1
        $task = Task::find($task_id);
        // 2
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();
        // 3
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}
