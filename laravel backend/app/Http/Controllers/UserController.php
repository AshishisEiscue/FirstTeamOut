<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
class UserController extends Controller{
// This function will return a random 
// string of specified length 
function random_strings($length_of_string) 
{ 
  
    // String of all alphanumeric character 
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
    // Shufle the $str_result and returns substring 
    // of specified length 
    return substr(str_shuffle($str_result),0, $length_of_string); 
} 
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $topUsers = User::orderBy('user_points', 'desc')->take(10)->get();
        return response()->json([
            'topUsers' => $topUsers,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        return view('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $user = $request->isMethod('put') ? User::findOrFail($request->id) : new User;
        $user->uid = $request->uid;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $random_reward_code = $this->random_strings(6);
        $user->reward_code = $random_reward_code; // User unique code
        $user->user_points = 0;
        $table = User::where('email',$user->email)->count();
        if($table == 1){
            return abort(501,'Email already exists');
        }
        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            return abort(403, 'Invalid Email Format,eg abc@xyz.com');
        }
        if(strlen($user->password) < 6){
            return abort(403, 'Password should be minimum six characters');
        }
        if($user->save()){
            $message = "User saved successfully";
        }else{
            $message = "User did not saved successfully";
        }
        return response()->json([
            'message' => $message,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('uid',$id)->first();

        return response()->json([
            'data' =>$user
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
        $user = User::where('uid',$id)->first();

        return response()->json([
            'data' =>$user
        ],200);
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
        $user  = User::findOrFail($id);

        $table = User::where('name',$user->name)->count();
        if($table == 1){
            return abort(501,'Username already exists');
        }

        $table = User::where('email',$user->email)->count();
        if($table == 1){
            return abort(501,'Email already exists');
        }

        if(strlen($user->password) < 6){
            return abort(403, 'Password should be minimum six characters');
        }
        $user->fill($request->all());
        list($message) = $user->save() ? array("User details updated successfully") : array(false , "User details failed to update.");

        return response()->json([
            'message' =>$message
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //get Users
        $user = User::findOrFail($id);

        if($user->delete()){
            return response()->json([
                'message' => "User deleted successfully"
            ],200);
        }
    }
    
    public function checkReferralCode(Request $request){
        $userInputReferral = $request->referral_code;
        $uid = $request->uid;
        $refCount = User::where('reward_code', $userInputReferral)->count();
        if($refCount == 0){
            $message = "Invalid Referral Code";
            return response()->json([
                'message' =>$message
            ],200);
        }else{
            $getUserReward = User::where('reward_code', $userInputReferral)->first();
            $getUserReward->user_points += 20;
            $getUserReward->save();
            $getCurrentUser = User::where('uid', $uid)->first();
            $getCurrentUser->referral_code = $userInputReferral;
            $getCurrentUser->user_points += 10;
            $getCurrentUser->save();
            $message = "Points Earned";
            return response()->json([
                'message' =>$message
            ],200);
        }
    }
}
