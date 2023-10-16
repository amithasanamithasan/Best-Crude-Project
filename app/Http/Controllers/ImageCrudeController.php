<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImageCrud;
use Session;
// update er jonno file class use kora lagbe
use File;
class ImageCrudeController extends Controller
{
   public function all_products(){
    $products= ImageCrud::all();
    //  return $products;
    
     return view ('products',compact('products'));
   }

   public function add_new_products ()
    {
    return view('add-new-product');
}
// jaheto product insert krbo ti request calss add krte hobe

// validation er kaj ta kora lagbe 
    // validate er moddhe akta array jabe[]
public function store_product(Request $request){
    
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

public  function edit_product($id){

     $product = ImageCrud::findOrFail($id);
    //  return $product;
    return view('edit-product',compact('product'));
}

// Update product logic unit
public function update_product (Request $request,$id){
    // validation er kaj ta kora lagbe 
    // validate er moddhe akta array jabe[]

    $product = ImageCrud::findOrFail($id);
    $request->validate([
        'name'=>'required',
        'email'=>'required',
        'address'=>'required',
        'number'=>'required',
    ]);
   
      $imageName='';
      $deleteOldImage= 'image/products/'.$product->image;
     

      if($image =$request->file('image')){
        if (file_exists($deleteOldImage)){
            File::delete($deleteOldImage);
          }
        $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move('image/products',$imageName);
      }else{
        $imageName=$product->image;
      }
      ImageCrud::where('id',$id)->update([
        'name'=>$request->name,
        'email'=>$request->email,
        'address'=>$request->address,
        'number'=>$request->number,
        'image'=>$imageName,
      ]);
      Session::flash ('msg','Product Update sucssfully');
      return redirect()->back();


    }
    public function delete_product($id)
{
  $product = ImageCrud::findOrFail($id);
  $deleteOldImage= 'image/products/'.$product->image;
  if (file_exists($deleteOldImage)){
    File::delete($deleteOldImage);
  }
  $product->delete();
  Session::flash ('msg','Product Deleted sucssfully');
  return redirect()->back();
}
}

