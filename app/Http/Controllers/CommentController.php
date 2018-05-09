<?php

namespace App\Http\Controllers;

use App\Comment;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommentController extends Controller
{
    
    public function commupdate(Request $request)
    {
        $comm = $request->input('comm');
        $cid = $request->input('cid');
        DB::table('comment_table')->where('comment_id','=',$cid)->update(array('comment_body'=>$comm));
        return back();
    }

    public function adminshow(){
     $result = DB::table('comment_table')
         ->leftjoin('ques_table','comment_table.ques_id','=','ques_table.ques_id')
         ->leftjoin('ans_table','comment_table.ans_id','=','ans_table.ans_id')
         ->leftjoin('user_basic','comment_table.user_id','=','user_basic.user_id')
         ->select('comment_table.*','ques_table.ques_heading','ques_table.slug','ans_table.ans_content','user_basic.username')
         ->orderBy('comment_table.created_at','desc')
         ->paginate(15);
        
        if(!empty($result)){
            return view('admin.comment',compact('result'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment_body = $request->input('commentbody');
        $ans_id = $request->input('ansid');
        $ques_id = $request->input('quesid');
        $user_id = Auth::user()->user_id;
        $created_at = Carbon::now('Asia/Kolkata');
        DB::table('comment_table')->insert(compact('comment_body','ans_id','ques_id','user_id','created_at'));
        DB::table('ans_extra')->where('ans_id','=',$ans_id)->increment('num_of_comments');
        return back();
    }

    public static function show($ansid)
    {
        $comment = DB::table('comment_table')->join('user_basic','user_basic.user_id','=','comment_table.user_id')->select('comment_table.comment_body','user_basic.username','user_basic.user_pic')->where('comment_table.ans_id','=',$ansid)->get();
            return $comment;
    }
    
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $z = DB::table('comment_table')->select('ans_id')->where('comment_id','=',$id)->first();
        DB::table('ans_extra')->where('ans_id','=',$z->ans_id)->decrement('num_of_comments');
        DB::table('comment_table')->where('comment_id','=',$id)->delete();
        return \Redirect::to($request->path());
    }
}
