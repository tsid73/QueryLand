<?php

namespace App\Http\Controllers;

use App\Subject;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class BasicController extends Controller
{

    public function markread($id)
    {
        DB::table('notifications')->where('id','=',$id)->update(array('read_at'=>Carbon::now('Asia/Kolkata')));
        echo "ok";
    }
    
    public function markall()
    {
        Auth::guard('admin')->user()->unreadNotifications->markAsRead();
        return back();
    }
    
     
    public function subshow($name)
    {
        $subj = Subject::where('subj_name','=',$name)->first();
        $result = DB::table('ques_table')->join('ques_extra','ques_table.ques_id','=','ques_extra.ques_id')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->leftjoin('sub_category','sub_category.sub_cat','=','ques_table.sub_cat')
            ->select('ques_table.*','ques_extra.*','user_basic.username','sub_category.category')
            ->where('ques_table.subject_id','=',$subj->subject_id)
            ->where('status','=',1)->paginate(10);
        
        $res = DB::table('ques_table')->leftjoin('ques_extra','ques_table.ques_id','=','ques_extra.ques_id')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->leftjoin('sub_category','sub_category.sub_cat','=','ques_table.sub_cat')
            ->select('ques_table.*','ques_extra.*','user_basic.username','sub_category.category')
            ->where('status','=',1)
            ->where('ques_table.subject_id','=',$subj->subject_id)
            ->where('ques_table.created_at','>',Carbon::now('Asia/Kolkata')->subdays(10))
            ->orderBy('ques_table.created_at','desc')
            ->paginate(10);
            
        $getmax = DB::table('ques_extra')->select('ques_table.ques_id')
            ->leftjoin('ques_table','ques_table.ques_id','=','ques_extra.ques_id')
            ->where('ques_table.subject_id','=',$subj->subject_id)
            ->orderBy('ques_views','desc')
            ->where('status','=',1)->get();
        foreach($getmax as $max)
        {
            $resu[] = DB::table('ques_table')->leftjoin('ques_extra','ques_table.ques_id','=','ques_extra.ques_id')
            ->leftjoin('user_basic','ques_table.user_id','=','user_basic.user_id')
            ->leftjoin('sub_category','sub_category.sub_cat','=','ques_table.sub_cat')
                ->select('ques_table.*','ques_extra.*','user_basic.username','sub_category.category')
            ->where('status','=',1)
            ->where('ques_table.subject_id','=',$subj->subject_id)
            ->where('ques_table.ques_id',$max->ques_id)
            ->first();
        }
                
        return view('templates.subject',compact('result','subj','res','resu'));
    }
    
    public function getsub(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->subj;
           $cat = DB::table('sub_category')->where('subject_id','=',$id)->distinct('sub_cat','category')->get();
            echo json_encode($cat);
            
        }
    }
    
    public function search(Request $request)
    {
        $res;
        if($request->searchmain=="")
        {
            return view('searching');
        }
        else
        {
            $res = DB::table('ques_table')->select('ques_heading','tags','slug','category')
                ->leftjoin('ques_extra','ques_table.ques_id','=','ques_extra.ques_id')
                ->leftjoin('sub_category','ques_table.sub_cat','=','sub_category.sub_cat')
                ->where('status','=',1)
                ->where('ques_heading','like','%'.$request->searchmain.'%')
                ->orWhere('tags','like','%,'.$request->searchmain.',%')
                ->orWhere('tags','like','%,'.$request->searchmain.'%')
                ->orWhere('tags','like','%'.$request->searchmain.',%')
                ->orWhere('tags','like','%'.$request->searchmain.'%')
                ->orWhere('sub_category.category','like','%'.$request->searchmain.'%')->get();
            if($res->count() > 0)
            {
                    return view('searching',compact('res'));
            }
            else{
                    return view('searching');
            }
            
        }    
    }
    
    public static function showsubject()
    {
        $sub = Subject::all('subj_name');
        return $sub;
    }
    
    public static function showsubjectcat()
    {
        $sub = DB::table('sub_category')->select('category')->get();
        return $sub;
    }
    
    public function editques($id){
        try{
        $ques = DB::table('ques_table')->leftjoin('subject_table','subject_table.subject_id','=','ques_table.subject_id')->leftjoin('sub_category','sub_category.sub_cat','=','ques_table.sub_cat')->select('ques_table.*','subject_table.subj_name','subject_table.subject_id','sub_category.category','sub_category.sub_cat')->where('ques_id',$id)->first();
        return view('editques',compact('ques'));
        }catch(Exception $e){
            abort(404);
        }
    }
    
    public function updateques(Request $request)
    {
        try{
            $ques_id = $request->input('quesid');
        $ques_heading = $request->input('title');
        $subject_id = $request->input('opt');
        $sub_cat = $request->input('subopt');
        $ques_content = $request->input('cont');
        $tags = $request->input('tag');
        $user_id = Auth::user()->user_id;
        $slug = Str::slug($ques_heading, $separator = '-');
        $updated_at = Carbon::now('Asia/Kolkata');
        $var = compact('ques_heading','subject_id','sub_cat','ques_content','tags','user_id','slug','updated_at');
        $id = DB::table('ques_table')->where('ques_id','=',$ques_id)->update($var);      
        
        return back()->with('id',1);
        }catch(Exception $e){
            return back()->with('id',0);
        }
        
    }
    
    public function deleteques(Request $request)
    {
        try{
        $id = $request->input('id');
        $user_id = Auth::user()->user_id;
        DB::table('ques_table')->where('ques_id','=',$id)->delete();
        DB::table('user_other')->where('user_id','=',$user_id)->decrement('user_xp',15);
        $this->check_level($user_id);
        return back();
        }catch(Exception $e){
            return back();
        }
    }
    
    public function deleteans(Request $request)
    {
        try{
        $id = $request->input('id');
        $user_id = Auth::user()->user_id;
        DB::table('ans_table')->where('ans_id','=',$id)->delete();
        DB::table('user_other')->where('user_id','=',$user_id)->decrement('user_xp',15);
        $this->check_level($user_id);
        return back();
        }catch(Exception $e){
            return back();
        }
    }
    public function deletecomm(Request $request)
    {
        try{
        $id = $request->input('id');
        $z = DB::table('comment_table')->select('ans_id')->where('comment_id','=',$id)->first();
        DB::table('comment_table')->where('comment_id','=',$id)->delete();
        DB::table('ans_extra')->where('ans_id','=',$z-ans_id)->decrement('num_of_comments');
        return back();
        }catch(Exception $e){
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
    
    public function checkuser(Request $request)
    {
        $user = $request->username;
        if($user == "")
        {
            return;
        }
       $re = DB::table('user_basic')->select('username')->where('username','=',$user)->first();
        if($re == null)
        {
            echo "no";
        }
        else
        {
            echo "yes";
        }
    } 
    
    public function checkemail(Request $request)
    {
        $user = $request->email;
        if($user == "")
        {
            return;
        }
       $re = DB::table('user_basic')->select('email')->where('email','=',$user)->first();
        if($re == null)
        {
            echo "no";
        }
        else
        {
            echo "yes";
        }
    }
    
    public function showabout(){
        try{
        $re = DB::table('image_table')->get();
        return view('who',compact('re'));
        }catch(Exception $e){
            return view('who');
        }
    }
    
    public function totalcount(Request $request){
        if($request->ajax())
        {
                $x =\App\Vote::where('ans_id','=',$request->ansid)->where('up',1)->count('up');
                $y =\App\Vote::where('ans_id','=',$request->ansid)->where('down',1)->count('down');
            $a = array();
            array_push($a,$x,$y);
        echo json_encode($a);
        }
    }
    
    public function best(Request $request){
        $ans = $request->ansid;
        $t = $request->type;
        $p = DB::table('ans_table')->select('ques_id')->where('ans_id',$ans)->first();
        if($t == 0)
        {
            DB::table('ques_extra')->where('ques_id',$p->ques_id)->update(array('best'=>null));
        }
        else
        {
            DB::table('ques_extra')->where('ques_id',$p->ques_id)->update(array('best'=>$ans));
        }
        echo "ok";
    }
    
    public function quesrept(Request $request){
        $quesid = $request->qid;
        $quesid = 'Ques: '. $quesid;
        $cont = $request->v;
        $u = Auth::user()->user_id;
    DB::table('report')->insert(['QorA'=>$quesid,
                                 'content'=>$cont,
                                 'user_id'=>$u,
                                 'created_at'=>Carbon::now('Asia/Kolkata')
                            ]);
    echo "ok";
    }
    
    public function ansrept(Request $request){
        $ansid = $request->aid;
        $ansid = 'Ans: '.$ansid;
        $cont = $request->v;
        $u = Auth::user()->user_id;
    DB::table('report')->insert([
        'QorA'=>$ansid,
        'content'=>$cont,
        'user_id'=>$u,
        'created_at'=>Carbon::now('Asia/Kolkata')]);
        echo "ok";
    }
    
    
}