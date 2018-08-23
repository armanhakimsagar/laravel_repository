<?php

namespace App\Http\Controllers;

use App\Task;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // space that we can use the repository from
   protected $model;

   public function __construct(Task $task)
   {
       // set the model
       $this->model = new Repository($task);
   }

   public function index()
   {
       $tasks = $this->model->all();
       return view('tasks',compact('tasks'));
   }

   public function store(Request $request)
   {
       $this->validate($request, [
           'name' => 'required|max:500'
       ]);

       // create record and pass in only fields that are fillable
       return $this->model->create($request->only($this->model->getModel()->fillable));
   }

   public function show($id)
   {
       $tasks = $this->model->show($id);
       return view('tasks',compact('tasks'));
   }

   public function update(Request $request, $id)
   {
       // update model and only pass in the fillable fields
       $this->model->update($request->only($this->model->getModel()->fillable), $id);

       return $this->model->find($id);
   }

   public function destroy($id)
   {
       $delete = $this->model->delete($id);
   }
}