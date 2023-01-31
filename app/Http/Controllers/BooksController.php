<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.

     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->id;
        $book_profile_view = DB::table('book_profile')->where('book_id',$id)
                            ->select('totalView')->first();
        $book_profile = DB::table('book_profile')->where('book_id',$id)
            ->update([
                'totalView' => $book_profile_view->totalView + 1,
            ]);

        $book = DB::table('book')
            ->join('book_profile', 'book_profile.book_id', '=', 'book.id')
            ->where('book.id', $id)
            ->select( 'book.id','book.name','book.description','book_profile.pic', 'book_profile.author', 'book_profile.totalView','book_profile.fileName')
            ->get();

        $category = DB::table('book_category')
            ->join('category', 'category.id', '=', 'book_category.category_id')
            ->where('book_category.book_id', $id)
            ->select('category.name')
            ->get();

        return response()->json([
            'success' => true,
            'book' => $book,
            'category' => $category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function readOnline(Request $request)
    {
        $id = $request->id;
        $book = DB::table('book_profile')
            ->where('book_id', $id)
            ->select('fileName')
            ->get();
        return $book;
    }

    public function booksStore(Request $request)
    {
        $userId = $request->userId;
        $books = DB::table('book_category')
            ->join('book', 'book.id', '=', 'book_category.book_id')
            ->join('book_profile', 'book_profile.book_id', '=', 'book_category.book_id')
            ->join('likes', 'likes.book_id', '=', 'book.id')
            ->where('likes.user_id', $userId)
            ->select( 'likes.id','book.name','book_profile.pic', 'book.id as bookId')
            ->orderBy('likes.index', 'ASC')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'books' => $books,
        ]);
    }

    public function sortBooksStore(Request $request){

        $i = 0;
        foreach ($request->arraySort as $id) {
            DB::table('likes')->where('id',$id)
                ->update([
                    'index' =>  $i,
                ]);
            $i++;
        }
        return response()->json([
            'success' => true,
        ]);
    }


    // search
    public function search(Request $request){
        $qry = $request->qry;
        if($qry!=""){
            $books= DB::table('book')
                ->where('name', 'like', '%'. $qry . '%')
                ->get();

            return $books;
        }
    }

    public function allBook(Request $request)
    {

        $books = DB::table('book_category')
            ->join('book', 'book.id', '=', 'book_category.book_id')
            ->join('book_profile', 'book_profile.book_id', '=', 'book_category.book_id')
            ->select( 'book.id','book.name','book_profile.author', 'book_profile.totalView', 'book_profile.countLike')
            ->orderBy('book_profile.totalView', 'DESC')
            ->paginate(12);

        return response()->json([
            'success' => true,
            'books' => $books,
        ]);
    }

    public function getDownload(Request $request)
    {
        
        $id = $request->id;
        $book = DB::table('book_profile')
            ->where('book_id', $id)
            ->select('fileName')
            ->get();
        $fileName = $book[0]->fileName;
        $file= public_path(). "/file/" . $fileName;
        $headers = array(
            'Content-Type: application/pdf',
        );
        // $book_profile_view = DB::table('book_profile')->where('book_id',$id)
        // ->select('countDownload')->first();
        // $book_profile = DB::table('book_profile')->where('book_id',$id)
        // ->update([
        //     'countDownload' => $book_profile_view->countDownload + 1,
        // ]);
        return Response::download($file,$fileName , $headers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info( 'image  ' . $request->pic);
        $image =  $request->pic->getClientOriginalName();
        $request->pic->move(public_path('images/books'), $image);

        Log::info( 'file ' . $request->file);
        $fileName =  $request->file->getClientOriginalName();
        $request->file->move(public_path('file'), $fileName);

        $book = DB::table('book')
            ->insertGetId([
                'name' => $request->name,
                'description' => $request->description,
                'created_at' =>\Carbon\Carbon::now()->toDateTimeString()
            ]);
        $book_profile = DB::table('book_profile')
            ->insert([
                'book_id' => $book,
                'pic' => $image,
                'author' => $request->author,
                'totalView' => 0,
                'hasPdf' => 1,
                'fileName' => $fileName,
                'created_at' =>\Carbon\Carbon::now()->toDateTimeString()
            ]);
        $book_category = DB::table('book_category')
            ->insert([
                'book_id' => $book,
                'category_id' => $request->category_id,
                'created_at' =>\Carbon\Carbon::now()->toDateTimeString()
            ]);
        return response()->json([
            'success' => true,
            'book' => $book,
        ]);
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
        Log::info('update book' . $id);

        Log::info( 'image  ' . $request->pic);
        $image =  $request->pic->getClientOriginalName();
        $request->pic->move(public_path('images/books'), $image);

        Log::info( 'file ' . $request->file);
        $fileName =  $request->file->getClientOriginalName();
        $request->file->move(public_path('file'), $fileName);

        $update = DB::table('book')->where('id',$id)
            ->update(['name' => $request->name,'description' => $request->description]);

        $book_profile = DB::table('book_profile')->where('book_id',$id)
            ->update([
                'pic' => $image,
                'author' => $request->author,
                'fileName' => $fileName,
            ]);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info( 'delete ' . $id);
        DB::table('book')
            ->where('id', $id)
            ->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}
