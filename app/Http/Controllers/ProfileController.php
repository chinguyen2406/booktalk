<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\friendships;
use App\notifcations;
class ProfileController extends Controller {

  public function index($slug) {
    $userData = DB::table('users')
    ->leftJoin('profiles', 'profiles.user_id','users.id')
    ->where('slug', $slug)
    ->get();
    // dd($userData);
    return $userData;
    // return view('profile.index', compact('userData'))->with('data', Auth::user()->profile);
  }

  // uploadPhoto == updateAvatar
  public function uploadPhoto( Request $request) {
    $file = $request->avatar;
    if(!empty($file)){
      $filename = $file->getClientOriginalName();

      $path = 'images';
      $file->move($path, $filename);
      $user_id = Auth::user()->id;
      DB::table('users')->where('id', $user_id)->update(['pic' => $filename]); 
    }
  }

  public function setToken(Request $request){
    $email = $request->email_address;
    
    //check any user have this email address
    $checkEmail = DB::table('users')->where('email',$email)->get();
    if(count($checkEmail)==0){
      echo "wrong email address";
    }else{
      $randomNumber = rand(1,500);
      $token_sl = bcrypt($randomNumber);
      $token = stripslashes($token_sl);

      $insert_token = DB::table('password_resets')->insert(['email' =>$email, 'token'=>$token,
      'created_at'=>\Carbon\Carbon::now()->toDateTimeString()]);

      //echo "send reset link to this email address";
      $baseUrl = 'http://hardeepcoder.com/laravel/larabook/getToken/'.$token;
      $to = $email;
      $subject = "Password reset Link";
      $message = "<a href='$baseUrl'>$token</a>";
      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: <admin@larabook.com>' . "\r\n";

      mail($to,$subject,$message,$headers);

    }

  }

  public function setPass(Request $request){
    $email = $request->email;
    $pass = $request->pass;
    $cpass = $request->confrim_pass;
    if($pass == $cpass){
      //update the pass for this user
      DB::table('users')->where('email',$email)->update(['password' =>bcrypt($pass)]);
      return back();
    }
    else{
      echo "passwords not matched";
    }

  }


  public function editProfileForm() {
    return Auth::user()->profile;
  }
  // updateProfile
  public function updateProfile(Request $request) {

    $user_id = Auth::user()->id;

    DB::table('profiles')->where('user_id', $user_id)->update(['city' => $request->city, 'country' => $request->country, 'about' => $request->about]);

  }
  // get all users
  public function getAllUsers() {
    $uid = Auth::user()->id;
    $allUsers = DB::table('profiles')
    ->leftJoin('users', 'users.id', '=', 'profiles.user_id')
    ->where('users.id', '!=', $uid)->get();
    // dd($allUsers);
    return $allUsers;
  }

  //  checkFriend
  public function checkFriend($idUser) {
    $check = DB::table('friendships')
    ->where('user_requested', '=', $idUser)
    ->where('requester', '=', Auth::user()->id)
    ->first();
    // dd($check);
    if($check == null) {
      return 0;
    }else{
      return 1;
    }
  }


  public function requests() {
    $uid = Auth::user()->id;

    $friendRequests = DB::table('friendships')
    ->rightJoin('users', 'users.id', '=', 'friendships.requester')
    ->where('status', '=', Null)
    ->where('friendships.user_requested', '=', $uid)->get();

    return $friendRequests;
  }

  public function accept( $id) {
    $uid = Auth::user()->id;

    $checkRequest = friendships::where('requester', $id)
    ->where('user_requested', $uid)
    ->first();

    if ($checkRequest) {
      // echo "yes, update here";

      $updateFriendship = DB::table('friendships')
      ->where('user_requested', $uid)
      ->where('requester', $id)
      ->update(['status' => 1]);

      $notifcations = new notifcations;
      $notifcations->note = 'accepted your friend request';
      $notifcations->user_hero = $id; // who is accepting my request
      $notifcations->user_logged = Auth::user()->id; // me
      $notifcations->status = '1'; // unread notifications
      $notifcations->save();
    } 
  }

  public function friends() {
    $uid = Auth::user()->id;

    $friends1 = DB::table('friendships')
    ->leftJoin('users', 'users.id', 'friendships.user_requested') // who is not loggedin but send request to
    ->where('status', 1)
    ->where('requester', $uid) // who is loggedin
    ->get();

    //dd($friends1);

    $friends2 = DB::table('friendships')
    ->leftJoin('users', 'users.id', 'friendships.requester')
    ->where('status', 1)
    ->where('user_requested', $uid)
    ->get();

    $friends = array_merge($friends1->toArray(), $friends2->toArray());

    return $friends;
  }

  public function unFriend($id){
    $loggedUser = Auth::user()->id;
    DB::table('friendships')
    ->where('requester', $loggedUser)
    ->where('user_requested', $id)
    ->delete();
    DB::table('friendships')
    ->where('user_requested', $loggedUser)
    ->where('requester', $id)
    ->delete();
    // get friends
    $uid = Auth::user()->id;
    $friends1 = DB::table('friendships')
    ->leftJoin('users', 'users.id', 'friendships.user_requested') // who is not loggedin but send request to
    ->where('status', 1)
    ->where('requester', $uid) // who is loggedin
    ->get();
    //dd($friends1);
    $friends2 = DB::table('friendships')
    ->leftJoin('users', 'users.id', 'friendships.requester')
    ->where('status', 1)
    ->where('user_requested', $uid)
    ->get();
    $friends = array_merge($friends1->toArray(), $friends2->toArray());
    return $friends;
  }

  public function requestRemove($id) {

    DB::table('friendships')
    ->where('user_requested', Auth::user()->id)
    ->where('requester', $id)
    ->delete();
  }

}
