<?php

namespace App\Http\Controllers;
use App\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function index()
    {

        return view('todos.index')->with('todos', Todo::all());
        /*todos:key的名稱。Todo::all():key的value。model Todo用靜態方法all(),去todos table 找出所有資料*/
    }
    public function show($todoId)
    {
       return view('todos.show')->with('todo',Todo::find($todoId));

    }
    public function create()
    {
       return view('todos.create');

    }
    public function store()
    {
        $this->validate(request(), [
            'name'=>'required',
            'description'=>'required'
        ]);
      $data=request()->all();/* 取得使用者填寫的所有資料*/
      $todo=new Todo();
      $todo->name=$data['name'];
      $todo->description=$data['description'];
      $todo->completed=false;
      $todo->save();
      session()->flash('success','新增成功!');
      return redirect('/todos');

    }

    public function edit(Todo $todo)
    {
        return view('todos.edit')->with('todo',$todo);
    }

    public function update(Todo $todo)
    {
        $this->validate(request(), [
            'name'=>'required',
            'description'=>'required'
        ]);

        $data = request()->all();
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->save();
        session()->flash('success','更新成功!');

        return redirect('/todos');

    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        session()->flash('success','刪除成功!');
        return redirect('/todos');

    }

    public function complete(Todo $todo)
    {
        $todo->completed = true;
        $todo->save();
        session()->flash('success','恭喜你完成了!');
        return redirect('/todos');


    }
}

