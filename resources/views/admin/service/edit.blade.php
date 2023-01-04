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
                    <div class="card">
                        <div class="card-header">Edit Data</div>
                            <div class="card-body">
                                <form action="{{url('service/update/'.$service->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="service_name">Image Name</label>
                                        <input type="text" class="form-control" name="service_name" value="{{$service->service_name}}">
                                    </div>       
                                    @error('service_name')
                                        <div class="my-2">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>                                    
                                    @enderror

                                    <div class="form-group">
                                        <label for="service_image">Image</label>
                                        <input type="file" class="form-control" name="service_image" value="{{$service->service_image}}">
                                    </div>       
                                    @error('service_name')
                                        <div class="my-2">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>                                    
                                    @enderror
                                    <br>     
                                    <input type="hidden" name="old_image" value="{{$service->service_image}}">
                                    <div class="form-group">
                                        <img src="{{asset($service->service_image)}}" alt="image" width="400px" heigth="400px">
                                    </div>    
                                    <br>
                                    <input type="submit" value="Update" class="btn btn-primary">
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
