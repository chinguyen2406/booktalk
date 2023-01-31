<?php

namespace App\Http\Controllers;

use App\User;
use App\profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
        ]);

//        if ($validator->fails())
//        {
//            return response()->json([
//                'status' => 'error',
//                'errors' => $validator>errors()
//            ], 422);
//        }

        if($request->gender=='male'){
            $pic_path = 'boy.png';
        }
        else
        {
            $pic_path = 'girl.png';
        }

        $user = new User;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->pic = $pic_path;
        $user->name = $request->name;
        $user->slug = str_slug($request->name, '-');
        $user->password = bcrypt($request->password);
        $user->save();

        $id = $user->id;
        $likes = $request->likes;
        Log::info($id);
        foreach ($request->likes as $categoryId) {
            DB::table('likes_category')
                ->insert([
                    'user_id' => $id,
                    'category_id' => $categoryId,
                    'created_at' =>\Carbon\Carbon::now()->toDateTimeString()
                ]);
        }

        Profile::create(['user_id' => $user->id,
        'city' => '',
        'country' => '',
        'about' => '',
    ]);

        return response()->json(['status' => 'success'], 200);
    }

     var $tokenApp = "";

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // tao token new when login
        if ($token = auth()->guard('api')->attempt($credentials)) {
            $this->tokenApp = $token;
            // dd($this->tokenApp);
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'login_error'], 401);
    }

    // logout
    public function logout()
    {
        $this->guard()->logout();

        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
    // refresh token
    public function refresh()
    {
        return response()
        ->json(['status' => 'successs'], 200)
        ->header('Authorization', $this->tokenApp);

        // if ($token = $this->guard()->refresh()) {
        //     return response()
        //         ->json(['status' => 'successs'], 200)
        //         ->header('Authorization', $token);
        // }

        // return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
