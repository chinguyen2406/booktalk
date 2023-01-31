<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;
use Log;

class UserController extends Controller
{
    // show all user
    public function index()
    {
        $users = DB::table('users')
            ->where('role','!=', 3)
            ->select( 'id','name','email','role')
            ->paginate(10);

        return response()->json(
            [
                'status' => 'success',
                'users' => $users
            ], 200);
    }

    // show 1 nguoi dung
    public function show(Request $request, $id)
    {
        $user = User::find($id);

        return response()->json(
            [
                'status' => 'success',
                'user' => $user->toArray()
            ], 200);
    }

    public function editUser(Request $request)
    {
        if($request->file){
            $image =  $request->file->getClientOriginalName();
            $request->file->move(public_path('images'), $image);
            $update = DB::table('users')->where('id',$request->id)
                ->update(['name' => $request->name,'email' => $request->email, 'pic' => $image]);
        }else {
            Log::info('no file');
            $update = DB::table('users')->where('id',$request->id)
                ->update(['name' => $request->name,'email' => $request->email]);
        }
        return response()->json(
            [
                'status' => 'success',
            ], 200);
    }

    public function likeCategory(Request $request)
    {
        Log::info('show request likeCategory:', ['request' => $request->all()]);
        DB::table('likes_category')
            ->where('user_id', $request->userId)
            ->delete();

        foreach ($request->likes as $categoryId) {
            DB::table('likes_category')
                ->insert([
                    'user_id' => $request->userId,
                    'category_id' => $categoryId,
                    'created_at' =>\Carbon\Carbon::now()->toDateTimeString()
                ]);
        }
        return response()->json([
            'success' => true,
        ]);
    }

    public function getLikeCategory(Request $request){
        $likes = DB::table('likes_category')
            ->join('category', 'category.id', '=', 'likes_category.category_id')
            ->where('likes_category.user_id', $request->userId)
            ->select( 'likes_category.category_id as id', 'category.name' )
            ->get();
        return response()->json([
            'success' => true,
            'data' => $likes,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info( 'delete ' . $id);
        DB::table('users')
            ->where('id', $id)
            ->delete();
        return response()->json([
            'success' => true,
        ]);
    }


}
