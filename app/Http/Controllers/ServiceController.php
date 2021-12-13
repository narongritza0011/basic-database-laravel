<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(5);
        return view('admin.service.index', compact('services'));
    }

    public function store(Request $request)
    {


        // ตรวจสอบข้อมูล
        $request->validate(
            [
                'service_name' => 'required|unique:services|max:255',
                'service_image' => 'required|mimes:jpg,jpeg,png'
            ],
            [
                'service_name.required' => "กรุณาป้อนชื่อบริการ",
                'service_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'service_name.unique' => "ชื่อบริการซ้ำ กรุณาป้อนใหม่",
                'service_image.required' => "กรุณใส่ภาพประกอบบริการ",
                'service_image.mimes' => "ประเภทของไฟล์รูปภาพไม่ถูกต้อง",
            ],

        );

        // dd($request->service_name, $request->service_image);

        //การเข้ารหัสรูปภาพ
        $service_image = $request->file('service_image');
        //generate ชื่อภาพ
        $name_gen = hexdec(uniqid());

        //ดึงนามสกุลไฟล์ภาพ
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        //รวมชื่อกับนามสกุลไฟล์ 
        $img_name = $name_gen . '.' . $img_ext;

        //บันทึกข้อมูลเเละอัพโหลด
        $upload_location = 'image/services/';
        $full_path = $upload_location . $img_name;
        Service::insert([
            'service_name' => $request->service_name,
            'service_image' => $full_path,
            'created_at' => Carbon::now()
        ]);
        //อัพโหลดภาพ
        $service_image->move($upload_location, $img_name);
        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อย");
    }

    public function edit($id)
    {
        $service = Service::find($id);
        //dd($department->department_name);


        return view('admin.service.edit', compact('service'));
    }


    public function update(Request $request, $id)
    {
        // ตรวจสอบข้อมูล
        $request->validate(
            [
                'service_name' => 'required|max:255',
                'service_image' => 'mimes:jpg,jpeg,png'
            ],
            [
                'service_name.required' => "กรุณาป้อนชื่อบริการ",
                'service_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'service_image.mimes' => "ประเภทของไฟล์รูปภาพไม่ถูกต้อง",
            ],

        );

        //การเข้ารหัสรูปภาพ
        $service_image = $request->file('service_image');

        //อัพเดทภาพเเละชื่อ
        if ($service_image) {


            //generate ชื่อภาพ
            $name_gen = hexdec(uniqid());

            //ดึงนามสกุลไฟล์ภาพ
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            //รวมชื่อกับนามสกุลไฟล์ 
            $img_name = $name_gen . '.' . $img_ext;

            //อัพโหลดเเละอัพเดทข้อมูล
            $upload_location = 'image/services/';
            $full_path = $upload_location . $img_name;


            //อัพเดทข้อมูล
            Service::find($id)->update([
                'service_name' => $request->service_name,
                'service_image' => $full_path,

            ]);

            //ลบภาพเก่าเเละอัพภาพใหม่เเทนที่
            $old_image = $request->old_image;
            unlink($old_image);

            //อัพโหลดภาพ
            $service_image->move($upload_location, $img_name);

            return redirect()->route('services')->with('success', "อัพเดทภาพเรียบร้อย");
        } else {
            //อัพเดทชื่ออย่างเดียว
            //อัพเดทข้อมูล
            Service::find($id)->update([
                'service_name' => $request->service_name,


            ]);
            return redirect()->route('services')->with('success', "อัพเดทชื่อบริการเรียบร้อย");
        }
    }

    public function delete($id)
    {

        //1.ลบภาพ
        $image = Service::find($id)->service_image;
        unlink($image);
        //2.ลบข้อมูลจากฐานข้อมูล
        $delete = Service::find($id)->delete();
        return redirect()->back()->with('success', "ลบข้อมูลเรียบร้อย");
    }
}
