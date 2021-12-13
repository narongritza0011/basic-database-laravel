<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\ErrorHandler\Debug;

class DepartmentController extends Controller
{
    public function index()
    {



        //ใช้ query builder
        //การ join ตาราง
        // $departments =  DB::table('departments')
        //     ->join('users', 'departments.user_id', 'users.id')
        //     ->select('departments.*', 'users.name')->paginate(5);
        // $departments = DB::table('departments')->paginate(5);
        // $departments =  DB::table('departments')->get();


        //ใช้ model
        $departments = Department::paginate(5);
        $trashDepartments = Department::onlyTrashed()->paginate(3);
        // $departments = Department::all();
        return view('admin.department.index', compact('departments', 'trashDepartments'));
        // echo  json_encode($departments) ;
    }

    public function store(Request $request)
    {
        //ตรวจสอบข้อมูล
        $request->validate(
            [
                'department_name' => 'required|unique:departments|max:255'

            ],
            [
                'department_name.required' => "กรุณาป้อนชื่อเเผนก",
                'department_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'department_name.unique' => "ชื่อเเผนกซ้ำ กรุณาป้อนใหม่"
            ],

        );
        //บันทึกข้อมูล ด้วย query builder
        $data = array();
        $data["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;
        //query builder
        DB::table('departments')->insert($data);
        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
    }


    public function edit($id)
    {
        $department = Department::find($id);
        //dd($department->department_name);


        return view('admin.department.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        //ตรวจสอบข้อมูล
        $request->validate(
            [
                'department_name' => 'required|unique:departments|max:255'

            ],
            [
                'department_name.required' => "กรุณาป้อนชื่อเเผนก",
                'department_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'department_name.unique' => "ชื่อเเผนกซ้ำ กรุณาป้อนใหม่"
            ],

        );
        //อัพเดทข้อมูล 
        $update = Department::find($id)->update([
            'department_name' => $request->department_name,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('department')->with('success', "อัพเดทข้อมูลเรียบร้อย");
        //  dd($id, $request->department_name);
    }

    public function softdelete($id)
    {
        //dd($id);
        $delete = Department::find($id)->delete();
        return redirect()->back()->with('success', "ลบข้อมูลเรียบร้อย");
    }

    public function restore($id)
    {
        $restore = Department::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success', "กู้คืนข้อมูลเรียบร้อย");
    }

    public function delete($id)
    {
        $delete = Department::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success', "ลบข้อมูลถาวรเรียบร้อย");
    }
}  






    // dd($request->department_name); การดีบัคดูค่าที่กรอกมาจาก form

    ////บันทึกข้อมูล ผ่าน model
    // $department = new Department;
    // $department->department_name = $request->department_name;
    // $department->user_id = Auth::user()->id;
    // $department->save();



    //   //บันทึกข้อมูล ด้วย query builder
    //   $data = array();
    //   $data["department_name"] = $request->department_name;
    //   $data["user_id"] = Auth::user()->id;
    //   //query builder
    //   DB::table('departments')->insert($data);
    //   return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");