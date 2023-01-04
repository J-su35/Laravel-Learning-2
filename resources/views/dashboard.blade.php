<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{Auth::user()->name}}

            <div class="float-end">User Now <span>{{count($users)}}</span></div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Start Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i=1)
                    @foreach($users as $row)
                    <tr>
                        <th>{{$i++}}</th>
                        <td>{{$row->name}}</td>
                        <td>{{$row->email}}</td>
                        {{-- Eloquent method --}}
                        {{-- <!-- <td>{{$row->created_at->diffForHumans()}}</td> --> --}} 
                        {{-- Query Builder method --}}
                        <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</x-app-layout>
