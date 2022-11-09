<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;

class ClientController extends Controller
{
    public function register(Request $request){
        $validator=validator()->make($request->all(),[
            'name'              => 'required',
            'email'             => 'required|email|unique:clients',
            'phone'             => 'required',
            'password'          => 'required|confirmed',
            'region_id'         => 'required|exists:regions,id'
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $request->merge(['password'=>bcrypt($request->password)]);
        $client=Client::create($request->all());
        $client->api_token=Str::random(60);
        $client->save();
        return responsejson(1,"تم الاضافه بنجاح",[
            'api_token' =>$client->api_token,
            'client'=>$client
        ]);
    }
    public function login(Request $request){
        $validator=validator()->make($request->all(),[
        'email'             => 'required|email',
        'password'          => 'required',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $client=Client::where('email',$request->email)->first();
        if($client){
            if(Hash::check($request->password,$client->password)){
                return responsejson(1," البيانات صحيحه ",[
                    'api_token' =>$client->api_token,
                    'client'=>$client
                ]);
            }else{
                return responsejson(0,'الرقم السري خطأ');
            }
        }else{
            return responsejson(0,'البيانات خطأ');
        }
    }
    public function showData(Request $request){
        $client=$request->user();
        return responsejson(1,'data',$client);
    }
    public function updateProfile(Request $request){
        $client=$request->user();
        if($client){
            $client->name=$request->name;
            $client->email=$request->email;
            $client->phone=$request->phone;
            $client->password=bcrypt($request->password);//راجع علي دي
            $client->region_id=$request->region_id;;
            $client->save();
        }else{
            return responsejson(0,'لا يوجد عميل بهذهي البيانات',$client);
        }
        return responsejson(1,'نجاح',$client);
    }
    public function reset(Request $request){
        $validator=validator()->make($request->all(),[
            'email'=>'required|email',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $user=Client::where('email',$request->email)->first();
        if($user){
            $code=rand(1111,9999);
            $user->pin_code=$code;
            // $user->save();
            $update=$user->update(['pin_code'=>$code]);
            if($update){

                Mail::to($request->user())
                    ->bcc('ahmedmohammedalkayyal@gmail.com')
                    ->send(new ResetPassword($code));
                    return responsejson(1,'برجاء فحص الايميل',[
                        'pin_code'=>$code,
                        'email'=>$user->email,
                    ]);
            }else{
                return responsejson(0,'حدث خطأ ما');
            }

        }
        return responsejson(0,'لا يوجد عميل بهذهي البيانات');
    }
}
