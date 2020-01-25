<?php

namespace App\Http\Controllers;
use App\ServicePurchase;
use App\Users;
use Illuminate\Http\Request;

class ServicePurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $service_purchase = new ServicePurchase;
        $service_purchase->uid = $request->uid;
        $service_purchase->service_id = $request->service_id;
        if($service_purchase->save()){
            $user= User::findOrFail($service_purchase->uid);
            $user->user_points = $user->user_points - 10;  
            $message = "user purchase saved successfully";
        }else{
            $message = "User purchase did not saved successfully";
        }
        return response()->json([
            'messsage' => $message,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = User::where('uid',$id)->first();
        return response()->json([
            'Service' =>$service
        ],200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkServicePurchase(Request $request){
        $check_purchased_servcice = ServicePurchase::where([['service_id',$request->service_id],['uid',$request->uid]])->count();
        if($check_purchased_servcice == 1){
            $is_purchases = true;
        }else{
            $is_purchases =false;
        }
        return response()->json([
            'message' =>$is_purchases
        ],200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
