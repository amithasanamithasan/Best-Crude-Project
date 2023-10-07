<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImageCrud;
use Session;
class ImageCrudeController extends Controller
{
   public function all_products(){
     return view ('products');
   }

   public function add_new_products ()
    {
    return view('add-new-product');
}
// jaheto product insert krbo ti request calss add krte hobe
public function store_product(Request $request){
    // validation er kaj ta kora lagbe 
    // validate er moddhe akta array jabe[]
    $request->validate([
        'name'=>'required',
        'email'=>'required',
        'address'=>'required',
        'number'=>'required',
        'image'=>'required|mimes:png,jpg,jpeg',

    ]);
      $imageName='';
      if($image =$request->file('image')){
        $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move('image/products',$imageName);
      }
      ImageCrud::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'address'=>$request->address,
        'number'=>$request->number,
        'image'=>$imageName,
      ]);
      Session::flash ('msg','Product Added sucssfully');
      return redirect()->back();
}

}

