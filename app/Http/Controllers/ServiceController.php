<?php

namespace App\Http\Controllers;

use App\Models\service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index() {
        $services = service::paginate(3);     
        return view('admin.service.index',compact('services')); 
    }

    public function edit($id) {
        $service = service::find($id);
        return view('admin.service.edit',compact('service'));
    }

    public function update(Request $request, $id){
        //validation
        $request->validate(
            [
            'service_name'=>'required|max:255',
            ],
            [
            'service_name.max'=>"หากินกับคนไทย หากินเป็นคนไทย พูดภาษาไทย",
            'service_name.required'=>"หัดเรียนภาษาไทย พูดภาษาไทยซะบ้าง",
            ]
        );
        //Encoding image
        $service_image = $request->file('service_image');

        //update only name
        if($service_image){
            $name_gen = hexdec(uniqid());
            //pull .format image file
            $img_ext = strtolower($service_image->getClientOriginalExtension());       
            $img_name = $name_gen.'.'.$img_ext;

            //Upload & Update
            $upload_location = 'image/services/';
            $full_path = $upload_location.$img_name;
            
            //Update
            service::find($id)->update([
                'service_name'=>$request->service_name,
                'service_image'=>$full_path,
        ]);
            //delete old image and upload new image
            $old_image = $request->old_image;
            unlink($old_image);
            $service_image->move($upload_location,$img_name);

            return redirect()->route('services')->with('success',"Update sucessful");   
        } else {
            //update image and name
            service::find($id)->update([
                'service_name'=>$request->service_name,
        ]);
        return redirect()->route('services')->with('success',"Update sucessful"); 
        }
        
    }

    public function store(Request $request) {
        //Validate
        $request->validate(
            [
            'service_name'=>'required|unique:services|max:255',
            'service_image'=>'required|mimes:jpg,jpeg,png'
            ],
            ['service_name.required'=>"หัดเรียนภาษาไทย พูดภาษาไทยซะบ้าง",
             'service_name.max'=>"หากินกับคนไทย หากินเป็นคนไทย พูดภาษาไทย",
             'service_name.unique'=>"กรุณาพูดภาษาไทย",
             'service_image.required'=>"หัดเรียนภาษาไทย พูดภาษาไทยซะบ้าง",
            ]
        );

        //Encoding image
        $service_image = $request->file('service_image');
        // dd($request->service_name, $request->service_image);
        //Generate file name
        $name_gen = hexdec(uniqid());
        //pull .format image file
        $img_ext = strtolower($service_image->getClientOriginalExtension());        

        $img_name = $name_gen.'.'.$img_ext;
        //Upload & Record
        $upload_location = 'image/services/';
        $full_path = $upload_location.$img_name;
        

        service::insert([
            'service_name'=>$request->service_name,
            'service_image'=>$full_path,
            'created_at'=>Carbon::now()
        ]);
        $service_image->move($upload_location,$img_name);
        return redirect()->back()->with('success',"Saved sucessful");     
    }

    public function delete($id) {
        //delete image
        $img = service::find($id)->service_image;
        unlink($img);
        
        $delete = service::find($id)->delete();

        return redirect()->back()->with('success', "Delete Successful");
    }
    
}
