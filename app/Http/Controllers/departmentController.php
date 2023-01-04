<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\department;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB; //Query Builder method


class departmentController extends Controller
{
    public function index() {
        // return view('admin.department.index');

        // Submit data by Eloquent method
        // $department=department::all();
        
        //Submit data by Query Builder
        // $department = DB::table('departments')->get();

        //pagination Eloquent method
        // $department=department::paginate(3);
        //pagination Query Builder method
        // $department = DB::table('departments')->paginate(3);

        //Connect table by Query Builder
        // $department = DB::table('departments')->join('users', 'departments.user_id', 'users.id')
        // ->select('departments.*','users.name')->paginate(3);

        //Delete Data
        $department = department::paginate(3);
        //Trash
        $trashDepartment = department::onlyTrashed()->paginate(3);

        // return view('admin.department.index',compact('department')); 
        //+Trash
        return view('admin.department.index',compact('department','trashDepartment')); 
    }

    public function store(Request $request) {
        //Validate
        $request->validate(
            [
            'department_name'=>'required|unique:departments|max:255'
            ],
            ['department_name.required'=>"หัดเรียนภาษาไทย พูดภาษาไทยซะบ้าง",
             'department_name.max'=>"หากินกับคนไทย หากินเป็นคนไทย พูดภาษาไทย",
             'department_name.unique'=>"กรุณาพูดภาษาไทย"
            ]
        );
        //Record
        // Eloquent method
        // $department = new department;
        // $department->department_name = $request->department_name;
        // $department->user_id = Auth::user()->id;
        // $department->save();

        // Query Builder method
        $data = array();
        $data["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;
        DB::table('departments')->insert($data);
        return redirect()->back()->with('success',"Saved");
    }

    public function edit($id) {
        $department = department::find($id);
        return view('admin.department.edit',compact('department'));
    }

    public function update(Request $request, $id){
        //validation
        $request->validate(
            [
            'department_name'=>'required|unique:departments|max:255'
            ],
            ['department_name.required'=>"หัดเรียนภาษาไทย พูดภาษาไทยซะบ้าง",
             'department_name.max'=>"หากินกับคนไทย หากินเป็นคนไทย พูดภาษาไทย",
             'department_name.unique'=>"กรุณาพูดภาษาไทย"
            ]
        );
        $update = department::find($id)->update([
            'department_name'=>$request->department_name,
            'user_id'=>Auth::user()->id
        ]);

        return redirect()->route('department')->with('success', "Update successful");
    }

    public function softdelete($id) {
        $del = department::find($id)->delete();

        return redirect()->back()->with('success', "Delete Successful");
    }

    public function restore($id) {
        $resotre = department::withTrashed()->find($id)->restore();

        return redirect()->back()->with('success', "Restore Successful");
    }

    public function delete($id) {
        $fdel = department::onlyTrashed()->find($id)->forceDelete();

        return redirect()->back()->with('success', "Delete Successful");
    }
}
