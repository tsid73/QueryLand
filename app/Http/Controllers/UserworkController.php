<?php

namespace App\Http\Controllers;

use App\Userwork;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class UserworkController extends Controller
{


    public function adminshow(){
        $result = DB::table('user_basic')->orderBy('created_at')->join('user_other','user_basic.user_id','=','user_other.user_id')->select('user_basic.*','user_other.*')
            ->orderBy('user_basic.created_at','desc')
            ->paginate(15);
        
        if(!empty($result)){
             return view('admin.user',compact('result'));
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
        $id = DB::table('user_basic')->insertGetId($request->except('user_field','_token'));
        Db::table('user_other')->insert(['user_id'=>$id,'user_field'=>$request->input('user_field')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Userwork  $userwork
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $result = DB::table('user_basic')->leftjoin('user_other','user_basic.user_id','=','user_other.user_id')->select('user_basic.*','user_other.*')->where('username','=',$name)->first();
        
        $ques_cont = DB::table('ques_table')->where('user_id','=',$result->user_id)->get();        
        if(!empty($ques_cont))
        {
            $ques = DB::table('ques_table')->where('user_id','=',$result->user_id)->count();
        }
        
        $ans_cont = DB::table('ans_table')->where('user_id','=',$result->user_id)->get();
        if(!empty($ans_cont))
        {
            $ans = DB::table('ans_table')->where('user_id','=',$result->user_id)->count();
        }
        
        $comment_cont = DB::table('comment_table')->where('user_id','=',$result->user_id)->get();
        if(!empty($comment_cont))
        {
            $comment = DB::table('comment_table')->where('user_id','=',$result->user_id)->count();
        }
        
        return view('templates.profile',compact('result','ques','ans','comment','ques_cont'));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        DB::table('user_basic')->where('user_id','=',$id)->delete();
        return \Redirect::to($request->path());
    }
}