<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี , <span class="text-primary">{{Auth::user()->name}}</span>

            <hr>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container "><a class="btn btn-outline-primary mb-2" href="{{route('department')}}">ย้อนกลับ</a>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            เเบบฟอร์มเเก้ไขข้อมูล
                        </div>
                        <div class="card-body">
                            <form action="{{url('/department/update/'.$department->id)}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">ชื่อเเผนก</label>
                                    <input type="text" class="form-control" value="{{$department->department_name}}" name="department_name">
                                    @error('department_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
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