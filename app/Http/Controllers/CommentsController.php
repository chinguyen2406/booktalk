<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use DB;
use Log;

class CommentsController extends Controller
{
	public function addComment(Request $request){
		$comment = $request->comment;
		$id = $request->id;
        Log::info( 'id ' . $request->id);
        Log::info( 'id ' . $comment);
        $createComment= DB::table('comments')
        ->insertGetId(['comment' =>$comment, 'user_id' => Auth::user()->id, 'book_id' => $id,
        'created_at' =>\Carbon\Carbon::now()->toDateTimeString()]);

        $comments = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->where('comments.id',$createComment )
            ->select( 'comments.id','comments.comment','comments.user_id','users.name', 'users.pic')
            ->get();

        return response()->json([
            'success' => true,
        ]);

    }

    public function comments(Request $request){
        Log::info( 'id ' . $request->id);
        $comments = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->where('comments.book_id', $request->id)
            ->select( 'comments.id','comments.comment','comments.user_id','users.name', 'users.pic')
            ->get();
        return response()->json([
            'success' => true,
            'comments' => $comments,
        ]);
    }

    public function allComments(Request $request){
        Log::info( 'id ' . $request->id);
        $comments = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->join('book', 'book.id', '=', 'comments.book_id')
            ->select( 'comments.id','comments.comment','users.name as userName', 'book.name as bookName')
            ->orderBy('comments.id', 'DESC')
            ->paginate(12);
        return response()->json([
            'success' => true,
            'comments' => $comments,
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
        DB::table('comments')
            ->where('id', $id)
            ->delete();
        return response()->json([
            'success' => true,
        ]);
    }

    public function updateComment($id, Request $request){

    }


}
