<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Resturant;
use Dotenv\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function register(Request $request){
        $validator=validator()->make($request->all(),[
            'name'          =>'required',
            'image'         =>'required',
            'status'        =>'required',
            'email'         =>'required|email|unique:restaurants',
            'phone'         =>'required',
            'password'      =>'required|confirmed',
            'minimum_order' =>'required',
            'mobile'        =>'required',
            'delivery'      =>'required',
            'whatsapp'      =>'required',
            'region_id'     => 'required|exists:regions,id'
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $request->merge(['password'=>bcrypt($request->password)]);
        $resturant=Resturant::create($request->except('image'));
        $resturant->api_token=Str::random(60);
        $file=$request->file('image')->storeAs('restaurants',Str::random(20).'.'.$request->file('image')->getClientOriginalExtension());
        // dd($file);
        $resturant->image='storage/'.$file;
        $resturant->save();
        return responsejson(1,"تم الاضافه بنجاح",[
            'api_token' =>$resturant->api_token,
            'resturant'=>$resturant
        ]);
    }
    public function login(Request $request){
        // dd("dskfkaskff");
        $validator=validator()->make($request->all(),[
            'email'         =>'required|email',//|unique:restaurants',
            'password'      =>'required',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $resturant=Resturant::where('email',$request->email)->first();
        // dd($resturant);
        if($resturant){
            if(Hash::check($request->password,$resturant->password)){
                return responsejson(1,'البيانات صحيحه ',[
                    'api_token' =>$resturant->api_token,
                    'client'=>$resturant
                ]);
            }else{
                return responsejson(0,'الرقم السري خطأ');
            }
        }else{
            return responsejson(0,'البيانات خطئ');
        }
    }
    public function showData(Request $request){
        $resturant=$request->user();
        if($resturant->count()){
            return responsejson(1,'data',$resturant);
        }else{
            return responsejson(0,"Error");
        }
    }
    public function updateProfile(Request $request){

    }
    public function addOffer(Request $request){
        $user = Auth::user()->id;
        $validator=validator()->make($request->all(),[
            'offer'             =>'required',
            'description'       =>'required',
            'image'             =>'required',
            'time_from'         =>'required',
            'time_to'           =>'required',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        // $offer=Offer::create($request->all());
        //     $offer=Offer::create($request->except('restaurant_id'));
        //     $offer->restaurant_id=$user;//مش شغال
        // //     // dd($item);
        //     $offer->save();
        $offer=new Offer();
        $offer->offer=$request->offer;
        $offer->description=$request->description;
        $offer->img=$request->image;
        $offer->time_from=$request->time_from;//الصيفه بتاع التاريخ بتتكتب ازاي
        $offer->time_to=$request->time_to;
        $offer->restaurant_id=$user;
        $offer->save();
        return responsejson(1,'تم الاضافه بنجاح',$offer);
    }
    public function restaurantOrder(Request $request){//مفيش حاجه بتظهر
        $validator=validator()->make($request->all(),[
            'status' =>'required|in:pending,accepted,rejected,delivered,decliened',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $id=Auth::user()->id;//اي البديل بتاعها
        // dd($id);
        if($request->status == 'pending'){
            $order=Order::where('state','pending')->where('restaurant_id',$id)->paginate(15);
            dd($order);
            return responsejson(1,"الاوردرات",$order);
        }elseif($request->status == 'accepted'){
            $order=Order::where('state','accepted')->where('restaurant_id',$id)->paginate(15);
            return responsejson(1,"الاوردرات",$order);
        }elseif($request->status == 'rejected'){
            $order=Order::where('state','rejected')->where('restaurant_id',$id)->paginate(15);
            return responsejson(1,"الاوردرات",$order);
        }elseif($request->status == 'delivered'){
            $order=Order::where('state','delivered')->where('restaurant_id',$id)->paginate(15);
            return responsejson(1,"الاوردرات",$order);
        }elseif($request->status == 'decliened'){
            $order=Order::where('state','decliened')->where('restaurant_id',$id)->paginate(15);
            return responsejson(1,"الاوردرات",$order);
        }else{
            return responsejson(0,'error');
        }
    }
}
