<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{Auth::user()->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if(session("success"))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">Department Table</div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Employee name</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($department as $row)
                                <tr>
                                    <th>{{$department->firstItem()+$loop->index}}</th>
                                    {{-- Eloquent method --}}
                                    <td>{{$row->department_name}}</td>
                                    {{-- <td>{{$row->user_id}}</td> --}}
                                    {{-- Query Builder method --}}
                                    {{-- <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td> --}}

                                    {{-- connect table by Eloquent method --}}
                                    <td>{{$row->user->name}}</td> 

                                    {{-- connect table by Query Builder method --}}
                                    {{-- <td>{{$row->name}}</td> --}}
                                    <td>
                                        <a href="{{url('/department/edit/'.$row->id)}}" class="btn btn-primary">Edit</a>
                                    </td>
                                    <td>
                                        <a href="{{url('/department/softdelete/'.$row->id)}}" class="btn btn-warning">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$department->links()}}
                    </div>
                    @if (count($trashDepartment)>0)                                        
                    <div class="card my-2">
                        <div class="card-header">Trash</div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Employee name</th>
                                        <th scope="col">Resotre data</th>
                                        <th scope="col">Permanent Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($i=1)
                                    @foreach($trashDepartment as $row)
                                    <tr>
                                        <th>{{$trashDepartment->firstItem()+$loop->index}}</th>
                                        {{-- Eloquent method --}}
                                        <td>{{$row->department_name}}</td>
                                        {{-- <td>{{$row->user_id}}</td> --}}
                                        {{-- Query Builder method --}}
                                        {{-- <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td> --}}

                                        {{-- connect table by Eloquent method --}}
                                        <td>{{$row->user->name}}</td> 

                                        {{-- connect table by Query Builder method --}}
                                        {{-- <td>{{$row->name}}</td> --}}
                                        <td>
                                            <a href="{{url('/department/restore/'.$row->id)}}" class="btn btn-primary">Restore</a>
                                        </td>
                                        <td>
                                            <a href="{{url('/department/delete/'.$row->id)}}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$trashDepartment->links()}}
                    </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Form</div>
                        <div class="card-body">
                            <form action="{{route('addDepartment')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">Department</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>       
                                @error('department_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>                                    
                                @enderror
                                <br>                        
                                <input type="submit" value="Save" class="btn btn-primary">
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
