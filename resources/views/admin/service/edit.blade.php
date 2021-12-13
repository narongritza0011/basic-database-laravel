<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี , <span class="text-primary">{{Auth::user()->name}}</span>

            <hr>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container "><a class="btn btn-outline-primary mb-2" href="{{route('services')}}">ย้อนกลับ</a>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            เเบบฟอร์มเเก้ไขข้อมูลบริการ
                        </div>
                        <div class="card-body">
                            <form action="{{url('/service/update/'.$service->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="service_name">ชื่อเเผนก</label>
                                    <input type="text" class="form-control" value="{{$service->service_name}}" name="service_name">
                                </div>
                                @error('service_name')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror


                                <div class="form-group">
                                    <label for="service_image">ภาพประกอบ</label>
                                    <input type="file" value="{{$service->service_image}}" class="form-control" name="service_image">
                                </div>
                                @error('service_image')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                                @enderror
                                <br>
                                <input type="hidden" name="old_image" value="{{$service->service_image}}">
                                <div class="form-group">
                                    <img height="200px" width="200px" src="{{asset($service->service_image)}}" alt="">
                                </div>

                                <input type="submit" value="อัพเดท" class="btn btn-outline-success mt-3 mb-2">
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>