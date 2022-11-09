<?php
function responsejson($status,$msg,$data=null){
    $response=[
        'status'    =>$status,
        'msg'       =>$msg,
        'data'      =>$data
    ];
    return response()->json($response);
}
function settings(){
    $settings=\App\Models\Setting::find(1);
    if($settings){
        return $settings;

    }else{
        return new \App\Models\Setting;
    }
}
?>
