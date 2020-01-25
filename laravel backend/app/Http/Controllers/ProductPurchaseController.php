<?php

namespace App\Http\Controllers;
use App\ProductPurchase;
use App\User;
use Illuminate\Http\Request;

class ProductPurchaseController extends Controller
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
    public function create(Request $request){
        $message ="";
        $purchaseProduct = new ProductPurchase;
        $purchaseProduct->uid = $request->uid;
        $purchaseProduct->product_id= $request->product_id;
        $user = User::where('uid',$request->uid)->first();
        if($purchaseProduct->save()){
            $user->user_points = $user->user_points - $request->product_price;
            $_10_percent_insentive = ($request->product_price * 0.10);
            $user->user_points = $user->user_points + $_10_percent_insentive;
            if($user->save()){
                $message = "You have earned ".$_10_percent_insentive." ₹ on the product! transaction compleated";
            }else{
                $message = "Transaction transaction failed";
            }
        }
        return response()->json([
            'msg' => $message,
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
        $product = User::where('uid',$id)->first();
        return response()->json([
            'singleProduct' =>$product
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
