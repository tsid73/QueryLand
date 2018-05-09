<?php

namespace App\Http\Controllers;

use App\Ans;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Notifications\AnsPost;
use Illuminate\Support\Facades\Mail;
use App\Mail\Ansnotify;
use App\Mail\Ansdel;
use App\Mail\QuesAns;
use Exception;


class AnsController extends Controller
{

    public function adminshow(){
        $result = DB::table('ans_table')->join('ans_extra','ans_table.ans_id','=','ans_extra.ans_id')->leftjoin('ques_table','ques_table.ques_id','=','ans_table.ques_id')->leftjoin('user_basic','ans_table.user_id','=','user_basic.user_id')->leftjoin('votes','votes.ans_id','=','ans_table.ans_id')->select('ans_table.*','ans_extra.*','ques_table.ques_heading','ques_table.slug','user_basic.name','user_basic.username','votes.up','votes.down')
            ->orderBy('ans_table.created_at','desc')
            ->paginate(15); 
        
        if(!empty($result)){
            return view('admin.ans',compact('result'));
        }
        
    }

    public function save(Request $request)
    {
        try{
       if($request->ajax())
        {
           $ques_id = $request->id;
           $ans_content = $request->cont;
           $user_id = Auth::user()->user_id;
            $created_at = Carbon::now('Asia/Kolkata');
            $var = compact('ques_id','ans_content','user_id','created_at');
            $id = DB::table('ans_table')->insertGetId($var,'ans_id');      
            DB::table('ans_extra')->insert(['ans_id'=>$id]);
           DB::table('user_other')->where('user_id','=',$user_id)->increment('user_xp',15);
           DB::table('ques_extra')->where('ques_id',$ques_id)->increment('num_of_ans');
           $this->check_level($user_id);
            echo "ok";
        }
            }
        catch(Exception $e){
            echo "not okay";
        }
    }
    
    public function fetch(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->rowid;
            $res =  DB::table('ans_table')->select('ans_table.ans_content')->where('ans_id','=',$id)->first();
            echo $res->ans_content; 
        }
    }

    public function ansupdate(Request $request)
    {
        try{
        $ans_content = $request->input('cont');
        $ans_id = $request->input('aid');
        DB::table('ans_table')->where('ans_id','=',$ans_id)->update(array('ans_content'=>$ans_content));
        return back();
        }catch(Exception $e)
        {
            return back();
        }
    }

    public function approve(Request $request)
    {
        $data = Input::all();
        $id = $data['id'];
        DB::table('ans_extra')->where('ans_id','=',$id)->update(array('status'=>'1'));
        DB::table('ans_table')->where('ans_id','=',$id)->update(array('created_at'=>Carbon::now('Asia/Kolkata')));
        $e = DB::table('ans_table')->select('ques_id','user_id')->where('ans_id','=',$id)->first();
        $u = DB::table('user_basic')->select('email')->where('user_id',$e->user_id)->first();
        $re = DB::table('ques_table')->select('slug','email')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->where('ques_id','=',$e->ques_id)->first();
        $subject = "Answer Approved";
        $vara = compact('subject','re');
        Mail::to($u->email)->queue(new Ansnotify($vara));
        Mail::to($re->email)->queue(new QuesAns($vara));
        
        return \Redirect::to($request->path());
    }
    
    public function disapprove(Request $request)
    {
        $data = Input::all();
        $id = $data['id'];
        DB::table('ans_extra')->where('ans_id','=',$id)->update(array('status'=>'0'));
        $e = DB::table('ans_table')->select('ques_id','user_id')->where('ans_id','=',$id)->first();
        $u = DB::table('user_basic')->select('email')->where('user_id',$e->user_id)->first();
        $re = DB::table('ques_table')->select('ques_heading')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->where('ques_id','=',$e->ques_id)->first();
        $subject = "Answer Disapproved";
        $vara = compact('subject','re');
        Mail::to($u->email)->queue(new Ansnotify($vara));
        
        return \Redirect::to($request->path());
    }
    
    public function destroy(Request $request)
    {
        $data = Input::all();
        $id = $data['id'];
        $user_id = DB::table('ans_table')->select('user_id','ques_id')->where('ans_id','=',$id)->first();
        DB::table('user_other')->where('user_id','=',$user_id->user_id)->decrement('user_xp',15);
        DB::table('ques_extra')->where('ques_id',$user_id->ques_id)->decrement('num_of_ans');
        $this->check_level($user_id->user_id);
        $e = DB::table('ans_table')->select('ques_id','user_id')->where('ans_id','=',$id)->first();
        $u = DB::table('user_basic')->select('email')->where('user_id',$e->user_id)->first();
        $re = DB::table('ques_table')->select('ques_heading')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->where('ques_id','=',$e->ques_id)->first();
        $subject = "Answer Deleted";
        $vara = compact('subject','re');
        Mail::to($u->email)->queue(new Ansdel($vara));
        
        DB::table('ans_table')->where('ans_id','=',$id)->delete();
        return \Redirect::to($request->path());
    }
    
     public function check_level($id)
    {
         $re = DB::table('user_other')->select('user_xp')->where('user_id','=',$id)->first();
         if($re->user_xp==null)
         {
             return;
         }
        if($re->user_xp>100)
        {
            DB::table('user_other')->where('user_id','=',$id)->increment('user_level');
            DB::table('user_other')->where('user_id','=',$id)->update(array('user_xp'=>'0'));
        }
        else if($re->user_xp<0)
        {
             DB::table('user_other')->where('user_id','=',$id)->decrement('user_level');
             $us = 100+$re->user_xp;
            DB::table('user_other')->where('user_id','=',$id)->update(array('user_xp'=>$us));
        }
    }
}