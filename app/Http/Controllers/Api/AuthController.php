<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth, Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string',
            'email'         => 'required|string|email|unique:users',
            'password'      => ['required', 'string', 'min:6']
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'vaidation error found.',
                'errors'    => $validator->errors()->all()
            ], 422);
        }

        //DB::beginTransaction();
        try {
            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $token = $user->createToken('User Token')->accessToken;
            //DB::commit();
            $user = array([
                'name'  => $request->name,
                'email' => $request->email
            ]);
            return response([ 'status' => 'success', 'message' => 'User created successfully.', 'data' => $user, 'token' => $token],200);
        }
        catch (\Exception $e)
        {
            $this->response = errorResponse($e);
        }

        //return $this->response;
    }
    /** 
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        //$user_info = $request->all();
        $email      = $request->email;
        $password   = $request->password;
        if(Auth::attempt(['email' => $email, 'password' => $password])){
            $user = Auth::user();
            $token = $user->createToken('User Token')->accessToken;
            
            return response([ 'status' => 'success', 'token' => $token],200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'User info are not correct. Please try valid info.'
            ], 401);
        }
        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function userDetails()
    {
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
            return response(['status' => 'success', 'data' => $user],200);
        }else{
            return response(['status' => 'failed', 'message' => 'Unauthorized'],401);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function logout(Request $request)
    {
        if(Auth::guard('api')->check()){
            $accessToken =  Auth::guard('api')->user()->token();

            \DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken)
                ->update(['revoked' => true]);
            $accessToken->revoke();
            return response()->json(['status' => 'success','message' => 'Successfully logged out']);
        }
        return response(['status' => 'failed', 'message' => 'Unauthorized'],401);
        
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
