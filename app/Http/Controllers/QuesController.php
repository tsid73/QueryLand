<?php

namespace App\Http\Controllers;

use App\Ques;
use App\Userwork;
use App\Subject;
use App\Admin;
use App\Ans;
use App\Quesextra;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Notifications\QuesPost;
use App\Notifications\UserInform;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\Sendnotification;
use App\Mail\Senddelete;

class QuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::table('ques_table')->leftjoin('ques_extra','ques_table.ques_id','=','ques_extra.ques_id')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->leftjoin('sub_category','sub_category.sub_cat','=','ques_table.sub_cat')
            ->select('ques_table.*','ques_extra.*','user_basic.username','sub_category.category')
            ->where('status','=',1)
            ->orderBy('ques_table.created_at','desc')
            ->paginate(10);
        $res = DB::table('ques_table')->leftjoin('ques_extra','ques_table.ques_id','=','ques_extra.ques_id')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->leftjoin('sub_category','sub_category.sub_cat','=','ques_table.sub_cat')
            ->select('ques_table.*','ques_extra.*','user_basic.username','sub_category.category')
            ->where('status','=',1)
            ->where('ques_table.created_at','>',Carbon::now('Asia/Kolkata')->subdays(10))
            ->orderBy('ques_table.created_at','desc')
            ->paginate(10);
            
        $getmax = DB::table('ques_extra')->select('ques_id')->orderBy('ques_views','desc')->where('status','=',1)->get();
        foreach($getmax as $max)
        {
            $resu[] = DB::table('ques_table')->leftjoin('ques_extra','ques_table.ques_id','=','ques_extra.ques_id')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->leftjoin('sub_category','sub_category.sub_cat','=','ques_table.sub_cat')
                ->select('ques_table.*','ques_extra.*','user_basic.username','sub_category.category')
            ->where('status','=',1)
            ->where('ques_table.ques_id',$max->ques_id)
            ->first();
        }
        $contri = DB::table('ans_table')->selectRaw('user_id,count(*) as maxap')->groupBy('user_id')->orderBy('maxap','desc')->limit(5)->get();
        foreach($contri as $cont)
        {
            $con[] = DB::table('user_basic')->leftjoin('user_other','user_other.user_id','=','user_basic.user_id')->select('username','user_pic','user_other.user_xp','user_other.user_level')->where('user_basic.user_id',$cont->user_id)->first();
        }
        return view('welcome',compact('result','con','res','resu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function adminshow(){

    $result = DB::table('ques_table')->leftjoin('ques_extra','ques_table.ques_id','=','ques_extra.ques_id')
        ->leftjoin('subject_table','ques_table.subject_id','=','subject_table.subject_id')
        ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
        ->leftjoin('sub_category','ques_table.sub_cat','=','sub_category.sub_cat')
        ->select('ques_table.*','ques_extra.*','subject_table.subj_name','user_basic.username','sub_category.category')->orderBy('ques_table.created_at','desc')->paginate(15); 
        
        if(!empty($result)){
            return view('admin.ques',compact('result'));
        }
    } 
       
       
    public function store(Request $request)
    {
        try{
        $ques_heading = $request->input('title');
        $subject_id = $request->input('opt');
        $sub_cat = $request->input('subopt');
        $ques_content = $request->input('cont');
        $words = $request->input('tag');
        $t = array_filter(explode(',',str_replace(',',' ',$words)));
        $tags = implode(",", $t);
        $user_id = Auth::user()->user_id;
        $slug = Str::slug($ques_heading, $separator = '-');
        $created_at = Carbon::now('Asia/Kolkata');
        $var = compact('ques_heading','subject_id','sub_cat','ques_content','tags','user_id','slug','created_at');
        $id = DB::table('ques_table')->insertGetId($var,'ques_id');      
        DB::table('ques_extra')->insert(['ques_id'=>$id]);
        $slug = $slug."-".$id;
        DB::table('ques_table')->where('ques_id',$id)->update(array('slug'=>$slug));
        $pass = compact('id','ques_heading','subject_id','ques_content','tags','user_id','slug','created_at');
        $user = Admin::find(1);
            $user->notify(new QuesPost($pass));
        DB::table('user_other')->where('user_id','=',$user_id)->increment('user_xp',15);
        $this->check_level($user_id);
            return back()->with('id',$id);
        }
        catch(Exception $e)
        {
            return back();
        }
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
    
    public function askshow(Ques $ques)
    {
        return view('ask');
    }

    public function show($slug){
        try{
        $result = DB::table('ques_table')->select('*')->where('slug','=',$slug)->first();
        $re = DB::table('user_basic')->select('username','name')->where('user_id','=',$result->user_id)->first();
        $answer = DB::table('ans_table')->leftjoin('ans_extra','ans_extra.ans_id','=','ans_table.ans_id')->leftjoin('user_basic','user_basic.user_id','=','ans_table.user_id')->select('ans_table.*','ans_extra.*','user_basic.name','user_basic.username','user_basic.user_pic')->where('ans_table.ques_id','=',$result->ques_id)
            ->where('status','=',1)->paginate(10);
        $id = $result->ques_id;
        $str = $result->ques_heading;
        $str=preg_replace('/\s+/', '', $str);
        $this->visit($str,$id);
        
        $view = Quesextra::select('ques_views')->where('ques_id',$result->ques_id)->first();
        $best = Quesextra::select('best')->where('ques_id',$result->ques_id)->first();
        if($best->best > 0)
        {
            return view('questions',compact('result','re','answer','view','best'));
        }
        return view('questions',compact('result','re','answer','view'));
        }
        catch(Exception $e)
        {
            abort(404);
        }
    }
    
        public function visit($str,$id)
   {
         $key = "CfPost".$str;
            $m= md5($key);
         $v = DB::table('ques_extra')->select('ques_views')->where('ques_id','=',$id)->first();
      if(!isset($_COOKIE[$m]))
      {
          $time = strtotime('next day 00:00');
          setcookie($m,'view',$time);
          DB::table('ques_extra')->where('ques_id','=',$id)->increment('ques_views');
      }   
   }
    
    public function search(Request $request)
    {
        if($request->ajax()){
            $res = DB::table('ques_table')->select('ques_heading','tags','slug','category')
                ->leftjoin('sub_category','ques_table.sub_cat','=','sub_category.sub_cat')
                ->where('ques_heading','like','%'.$request->search.'%')
                ->orWhere('tags','like','%'.$request->search.'%')
                ->orWhere('sub_category.category','like','%'.$request->search.'%')
                ->get();
            echo json_encode($res);
        }
    }
    
    public function votes(Request $request)
{
        if($request->ajax())
        {
            if(Auth::check())
            {
                $uid = Auth::user()->user_id;
                
                $votes = DB::table('votes')->select('user_id')
                    ->where('user_id','=',$uid)
                    ->where('ans_id','=',$request->ansid)
                    ->first();
            if($votes=="")
            {
                    if($request->type==1)
                 {   
                    $id = DB::table('votes')->insertGetId(array('user_id'=>$uid,'ans_id'=>$request->ansid));
                    DB::table('votes')->where('id','=',$id)->increment('up');
                        echo "like";
                 }
                    if($request->type==0)
                 {
                    $id = DB::table('votes')->insertGetId(array('user_id'=>$uid,'ans_id'=>$request->ansid));
                    DB::table('votes')->where('id','=',$id)->increment('down');
                        echo "dislike";
                 }
            }
            else
            {
                if($request->type==1)
                {
                    DB::table('votes')
                        ->where('user_id','=',$votes->user_id)
                        ->where('ans_id','=',$request->ansid)
                        ->increment('up');
                    $check = DB::table('votes')->select('down')->where('user_id','=',$votes->user_id)->where('ans_id','=',$request->ansid)
                        ->first();
                    if($check->down > 0)
                    {
                         DB::table('votes')->where('user_id','=',$votes->user_id)
                        ->where('ans_id','=',$request->ansid)
                        ->decrement('down');
                    }
                    echo "like";
                }
                else if($request->type==0)
                {
                    DB::table('votes')->where('user_id','=',$votes->user_id)->where('ans_id','=',$request->ansid)
                        ->increment('down');
            $check = DB::table('votes')->select('up')->where('user_id','=',$votes->user_id)->where('ans_id','=',$request->ansid)
                        ->first();
                    if($check->up > 0)
                    {
                        DB::table('votes')->where('user_id','=',$votes->user_id)->where('ans_id','=',$request->ansid)
                        ->decrement('up');
                    }
                    
                    echo "dislike";
                }
                else if($request->type==3)
                {
                    DB::table('votes')
                        ->where('user_id','=',$votes->user_id)
                        ->where('ans_id','=',$request->ansid)
                        ->decrement('up');
                    $r = DB::table('votes')->where('user_id','=',$votes->user_id)
                        ->where('ans_id','=',$request->ansid)->select('up','down')->first();
                    if($r->up == 0 AND $r->down == 0){
                        DB::table('votes')->where('user_id','=',$votes->user_id)
                        ->where('ans_id','=',$request->ansid)->delete();
                    }
                    echo "oka";
                }
                else if($request->type==4)
                {
                    DB::table('votes')->where('user_id','=',$votes->user_id)->where('ans_id','=',$request->ansid)
                        ->decrement('down');
                     $r = DB::table('votes')->where('user_id','=',$votes->user_id)
                        ->where('ans_id','=',$request->ansid)->select('up','down')->first();
                    if($r->up == 0 AND $r->down == 0){
                        DB::table('votes')->where('user_id','=',$votes->user_id)
                        ->where('ans_id','=',$request->ansid)->delete();
                    }
                    echo "oky";
                }
            }
        }
            else
            {echo "user";}
        
    }
                
}
    
    public function approve(Request $request)
    {
        $id = $request->id;
        DB::table('ques_extra')->where('ques_id','=',$id)->update(array('status'=>'1'));
        DB::table('ques_table')->where('ques_id','=',$id)->update(array('created_at'=>Carbon::now('Asia/Kolkata')));
        $re = DB::table('ques_table')->select('slug','email')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->where('ques_id','=',$id)->first();
        $subject = "Question Approved";
        $vara = compact('subject','re');
        Mail::to($re->email)->queue(new Sendnotification($vara));
         return back();
        
    } 
    
    public function approveajax(Request $request){
        if($request->ajax())
        {
        $id = $request->id;
        DB::table('ques_extra')->where('ques_id','=',$id)->update(array('status'=>'1'));
        DB::table('ques_table')->where('ques_id','=',$id)->update(array('created_at'=>Carbon::now('Asia/Kolkata')));
        $re = DB::table('ques_table')->select('slug','email')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->where('ques_id','=',$id)->first();
        $subject = "Question Approved";
        $vara = compact('subject','re');
        Mail::to($re->email)->queue(new Sendnotification($vara));
        echo "ok";
        }
    }
    
    public function disapprove(Request $request)
    {
        $id = $request->input('id');
        DB::table('ques_extra')->where('ques_id','=',$id)->update(array('status'=>'0'));
        $re = DB::table('ques_table')->select('ques_heading','email')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->where('ques_id','=',$id)->first();
        $subject = "Question Disapproved";
        $vara = compact('subject','re');
        Mail::to($re->email)->queue(new Sendnotification($vara));
        return \Redirect::to($request->path());
        
    }
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $user_id = DB::table('ques_table')->select('user_id')->where('ques_id','=',$id)->first();
        DB::table('user_other')->where('user_id','=',$user_id->user_id)->decrement('user_xp',15);
        $this->check_level($user_id->user_id);
        $re = DB::table('ques_table')->select('ques_heading','email')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->where('ques_id','=',$id)->first();
        DB::table('ques_table')->where('ques_id','=',$id)->delete();
        $subject = "Question Deleted";
        $vara = compact('subject','re');
        Mail::to($re->email)->queue(new Senddelete($vara));
        return \Redirect::to($request->path());   
    }
}