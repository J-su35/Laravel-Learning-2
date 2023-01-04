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
                        <div class="card-header">Image Table</div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Image name</th>
                                    <th scope="col">Create</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($services as $row)
                                <tr>
                                    <th>{{$services->firstItem()+$loop->index}}</th>
                                    {{-- Eloquent method --}}
                                    <td><img src="{{asset($row->service_image)}}" alt="image" width="100px" heigth="100px"></td>
                                  
                                    <td>{{$row->service_name}}</td> 
                                    
                                    <td>
                                        @if($row->created_at == NULL)
                                            Undifined
                                        @else
                                            {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{url('/service/edit/'.$row->id)}}" class="btn btn-primary">Edit</a>
                                    </td>
                                    <td>
                                        <a href="{{url('/service/delete/'.$row->id)}}" class="btn btn-warning" onclick="return confirm('Do you want to delete image?')">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$services->links()}}
                    </div>
                    
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Save Form</div>
                        <div class="card-body">
                            <form action="{{route('addService')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="Image_name">Image name</label>
                                    <input type="text" class="form-control" name="service_name">
                                </div>       
                                @error('service_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>                                    
                                @enderror
                                <div class="form-group">
                                    <label for="service_image">Image</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>       
                                @error('service_name')
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
