<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Region;
use App\Models\Resturant;
use App\Models\Setting;
use Illuminate\Http\Request;

class MainController extends Controller
{
      //بدايه الجزء الخاص باالمكان
    public function cities(){
        $cities=City::paginate(20);
        return responsejson(1,'success',$cities);
    }
    public function regions(Request $request){

        $regions=Region::where(function($query) use($request){
            if($request->has('city_id')){
                $query->where('city_id',$request->city_id);
            }
        })->get();
        return responsejson(1,'success',$regions);
    }
    public function category(){
        $category=Category::paginate(20);
        return responsejson(1,'success',$category);
    }
        //بدايه الجزء الخاص ب المطاعم
    public function restaurants(Request $request){
        $restaurants=Resturant::where(function($query) use($request){
            if($request->has('region_id')){
                $query->where('region_id',$request->region_id);
            }
        })->get();
        return responsejson(1,'success',$restaurants);
    }
    public function restaurant(Request $request){
        $restaurant=Resturant::findorfail($request->id);
        if($restaurant){
            return responsejson(1,'success',$restaurant);
        }
        return responsejson(0,'بيانات خطأ');
    }
    //اصناف المطاعم
    public function restaurantItems(Request $request){
        $items=Item::where(function($query) use($request){
            if($request->has('restaurant_id')){
                $query->where('restaurant_id',$request->restaurant_id);
            }
        })->paginate(10);
        return responsejson(1,'success',$items);
    }
    public function comments(Request $request){
         //انهي كود صح
        //1
        $comments=Comment::where('restaurant_id',$request->restaurant_id)->get();
        if($comments->count()){
            return responsejson(1,'success',$comments);
        }else{
            return responsejson(1,'لايوجد تعليقات لهذا المطعم');
        }
        // ملاحطه في الكود الي فوق حتي لو مفيش مطعم بيطلع اول رساله
        //2
        // $comments=Comment::where(function($query) use($request){
        //     if($request->has('restaurant_id')){
        //         $query->where('restaurant_id',$request->restaurant_id);
        //     }
        // })->paginate(10);
        // return responsejson(1,'تم بنجاح',$comments);
    }
    public function addComent(Request $request){
        // $cliend_id=Auth::guard('client')->user()->id;
        // return $cliend_id;
        $validator=validator()->make($request->all(),[
            'comment'           =>'required',
            'restaurant_id'     =>'required|exists:restaurants,id',
            'emoji'             =>'required',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }

        // $comment = Auth::guard('client')->user()->comments()->create($request->validated());
        $cliend_id=Auth::guard('client')->user()->id;
        $comment=new Comment;
        $comment->comment=$request->comment;
        $comment->restaurant_id=$request->restaurant_id;
        $comment->emoji=$request->emoji;
        $comment->client_id=$cliend_id;
        $comment->save();
        return responsejson(1,'تم الاضافه',$comment);
        // $comment=Comment::create($request->except('cliend_id'));
        // $comment->client_id=$cliend_id;
        // $comment->save();
        // return responsejson(1,'تم الاضافه',$comment);
    }
    public function newOrder(Request $request){
        $validator=validator()->make($request->all(),[
            'restaurant_id'=>'required|exists:restaurants,id',
            'items.*.item_id'=>'required|exists:items,id',
            'items.*.quantity'=>'required',
            'address'=>'required',
            'payment_id'=>'required|exists:payments,id',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        // info("pass valid");
        //if restaurant close
        $restaurant=Resturant::find($request->restaurant_id);
        if($restaurant->status=='STATUS_CLOSE'){
            return responsejson(0,'عذرا المطعم مغلق الان الرجاء الطلب في وقت لاحق ');
        }
        $order=$request->user()->orders()->create([
            'restaurant_id'=>$request->restaurant_id,
            'address'=>$request->address,
            'state'=>'pending',
            'note'=>$request->note,
            'payment_id'=>$request->payment_id,
        ]);
        // dd($order);
        $cost=0;
        $delivery_cost=$restaurant->delivery;
        foreach($request->items as $item){
            $test_item =Item::find($item['item_id']);
            $readyItem=[
                    $test_item['item_id']=>[
                        'quantity'=>$item['quantity'],
                        'price'=>$test_item->price,
                        'note'=>(isset($item['note']))?$item['note']:'',
                    ]
                ];
            // dd($readyItem);
            $order->items()->attach($readyItem);
            dd($order);
            $cost += ($item->price * $item['quantity']);
        }
        //minimum charge
        if($cost >= $restaurant->minimum_order){
            $total=$cost +$delivery_cost;
            $site_commission=settings()->commission*$cost;
            $update=$order->update([
                'cost'=>$cost,
                'delivery_cost'=>$delivery_cost,
                'total'=>$total,
                'site_commission'=>$site_commission,
            ]);
        }
    }
    //setting
    public function updateSetting (Request $request){
        $validator=validator()->make($request->all(),[
            'about_app'         =>'required',
            'phone'             =>'required',
            'email'             =>'required',
            'fb_link'           =>'required',
            'inst_link'         =>'required',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $update=Setting::where('id',1)->update($request->all());
        return responsejson(1,'success',$update);
    }
    public function setting(){
        $setting=Setting::get();
        return responsejson(1,'success',$setting);
    }
}
