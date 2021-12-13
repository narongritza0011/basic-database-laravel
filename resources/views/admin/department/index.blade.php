<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี , <span class="text-primary">{{Auth::user()->name}}</span>

            <hr>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container ">
            <div class="row">
                <div class="col-md-8">
                    @if(session("success"))
                    <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            ตารางข้อมูลเเผนก
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ชื่อ</th>
                                <th scope="col">พนักงาน</th>
                                <th scope="col">เวลาที่สร้าง</th>
                                <th scope="col">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($departments as $row)
                            <tr>
                                <th>{{$departments->firstItem()+$loop->index}}</th>
                                <td>{{$row->department_name}}</td>
                                <td>{{$row->user->name}}</td>
                                <td>@if($row->created_at == NULL)
                                    ไม่มีข้อมูล
                                    @else
                                    {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            จัดการ
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <li><a class="dropdown-item text-warning" href="{{url('/department/edit/'.$row->id)}}">เเก้ไข</a></li>
                                            <li><a class="dropdown-item text-danger" href="{{url('/department/softdelete/'.$row->id)}}">ลบ</a></li>

                                        </ul>
                                    </div>
                                </td>

                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    {{$departments->links()}}
                    @if(count($trashDepartments)>0)
                    <div class="card my-2">
                        <div class="card-header">
                            ถังขยะ
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อ</th>
                                    <th scope="col">พนักงาน</th>
                                    <th scope="col">วันเวลา</th>
                                    <th scope="col">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($trashDepartments as $row)
                                <tr>
                                    <th>{{$trashDepartments->firstItem()+$loop->index}}</th>
                                    <td>{{$row->department_name}}</td>
                                    <td>{{$row->user->name}}</td>
                                    <td>@if($row->created_at == NULL)
                                        ไม่มีข้อมูล
                                        @else
                                        {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                จัดการ
                                            </a>

                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li><a class="dropdown-item text-warning" href="{{url('/department/restore/'.$row->id)}}">กู้คืนข้อมูล</a></li>
                                                <li><a class="dropdown-item text-danger" onclick="return confirm('คุณต้องการลบข้อมูลเเผนกนี้หรือไม่ ?')" href="{{url('/department/delete/'.$row->id)}}">ลบข้อมูลถาวร</a></li>

                                            </ul>
                                        </div>
                                    </td>

                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                        {{$trashDepartments->links()}}
                    </div>

                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            เเบบฟอร์ม
                        </div>
                        <div class="card-body">
                            <form action="{{route('addDepartment')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">ชื่อเเผนก</label>
                                    <input type="text" class="form-control" name="department_name">
                                    @error('department_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                </div>

                                <input type="submit" value="บันทึก" class="btn btn-outline-success mt-3 mb-2">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>