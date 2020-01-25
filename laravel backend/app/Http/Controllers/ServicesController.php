<?php

namespace App\Http\Controllers;
use App\User;
use App\Services;
use App\UserPurchase;
use App\ServicePurchase;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $services = Services::get();
        return response()->json([
            'services' => $services,
        ],200);
    }
    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function redeemService(Request $request){
        $selectedServices = Services::findOrFail($request->service_id);
        return response()->json([
            'singleService' => $selectedServices
        ],200);
    }
    

    public function checkRedemption(Request $request){
        $getServiceId = $request->service_id;
        $getUid = $request->uid;
        $getService = Services::where('id', $getServiceId)->first();
        $getServicePrice = $getService->service_points;
        $user = User::where('uid', $getUid)->first();
        if($user->user_points >= $getServicePrice){
            $user->user_points = $user->user_points - $getServicePrice;
            if($user->save()){
                $is_redeemed = "true";
                $message = "Service has been redeemed";
            }else{
                $is_redeemed = "false";
                $message = "Unsuccessful transaction low balance ";
            }
        }
        return response()->json([
            'is_redeemed' => $is_redeemed,
            'messsage' => $message,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $getService = Services::where('id', $request->id)->first();   
        return response()->json([
            'service' => $getService
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Services $services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $services)
    {
        //
    }
}
