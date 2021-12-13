<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี , <span class="text-primary">{{Auth::user()->name}}</span>
            
            <b class="float-end">จำนวนผู้ใช้ระบบทั้งหมด <span class="text-success">{{count($users)}}</span> คน</b>
            <hr> รายการสมาชิก
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container shadow">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">อีเมล์</th>
                            <th scope="col">วันที่สร้าง</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $row)
                        <tr>
                            <th>{{$row->id}}</th>
                            <td>{{$row->name}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>