<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    public function addItem(Request $request){
        $user = Auth::user()->id;
        $validator=validator()->make($request->all(),[
            'name'          =>'required',
            'description'   =>'required',
            'image'         =>'required',
            'price'         =>'required',
            'order_time'    =>'required',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $item=Item::create($request->all());
        // $item=Item::create($request->except('restaurant_id'));
        $item->restaurant_id=$user;
        // dd($item);
        $item->save();
        return responsejson(1,'تم الاضافه بنجاح',$item);
    }
    public function updateItem(Request $request){
        $validator=validator()->make($request->all(),[
            'item_id'       =>'required|exists:items,id',
            'name'          =>'required',
            'description'   =>'required',
            'image'         =>'required',
            'price'         =>'required',
            'order_time'    =>'required',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $item=Item::find($request->item_id);
        // dd($item);
        if ($item->count()){
            $update=$item->update($request->all());
            return responsejson(1,'تم التعديل بنجاح',$update);
        }else{
            return responsejson(0,'error');
        }
    }
    public function destroy(Request $request){
        $validator=validator()->make($request->all(),[
            'item_id'       =>'required|exists:items,id',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $item=Item::find($request->item_id);
        // dd($item);
        if ($item->count()){
            $item->delete();
            return responsejson(1,'تم الحذف بنجاح');
        }else{
            return responsejson(0,'error');
        }
    }
}
