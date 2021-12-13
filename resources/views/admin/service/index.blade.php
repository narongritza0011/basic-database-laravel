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
                            ตารางข้อมูลบริการ
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ภาพประกอบ</th>
                                <th scope="col">ชื่อบริการ</th>
                                <th scope="col">เวลาที่สร้าง</th>
                                <th scope="col">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($services as $row)
                            <tr>
                                <th>{{$services->firstItem()+$loop->index}}</th>
                                <td><img src="{{asset($row->service_image)}}" width="100px" height="100px" alt=""></td>
                                <td>{{$row->service_name}}</td>

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
                                            <li><a class="dropdown-item text-warning" href="{{url('/service/edit/'.$row->id)}}">เเก้ไข</a></li>
                                            <li><a class="dropdown-item text-danger" onclick="return confirm('คุณต้องการลบข้อมูลบริการนี้หรือไม่ ?')" href="{{url('/service/delete/'.$row->id)}}">ลบ</a></li>

                                        </ul>
                                    </div>
                                </td>

                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                    {{$services->links()}}

                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            เเบบฟอร์มบริการ
                        </div>
                        <div class="card-body">
                            <form action="{{route('addService')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="service_name">ชื่อบริการ</label>
                                    <input type="text" class="form-control" name="service_name">
                                </div>
                                @error('service_name')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror

                                <div class="form-group">
                                    <label for="service_image">ภาพประกอบ</label>

                                    <input type="file" class="form-control" name="service_image">
                                </div>
                                @error('service_image')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror


                                <input type="submit" value="บันทึก" class="btn btn-outline-success mt-3 mb-2">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>