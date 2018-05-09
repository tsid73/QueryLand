<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class ProfileController extends Controller
{
    public function show($name)
    {
        try{
        $result = DB::table('user_basic')->leftjoin('user_other','user_basic.user_id','=','user_other.user_id')->select('user_basic.*','user_other.*','user_basic.user_id')->where('username','=',$name)->first();
        
       $ques_cont = DB::table('ques_table')->where('user_id','=',$result->user_id)->paginate(15);        
        if(!empty($ques_cont))
        {
            $ques = DB::table('ques_table')->where('user_id','=',$result->user_id)->count();
        }
        
        $ans_cont = DB::table('ans_table')->leftjoin('ques_table','ans_table.ques_id','=','ques_table.ques_id')->select('ans_table.*','ques_table.ques_heading','ques_table.slug')->where('ans_table.user_id','=',$result->user_id)->paginate(15);
        if(!empty($ans_cont))
        {
            $ans = DB::table('ans_table')->where('user_id','=',$result->user_id)->count();
        }
        
        $comment_cont = DB::table('comment_table')->leftjoin('ques_table','comment_table.ques_id','=','ques_table.ques_id')->select('comment_table.*','ques_table.ques_heading','ques_table.slug')->where('comment_table.user_id','=',$result->user_id)->paginate(15);
        if(!empty($comment_cont))
        {
            $comment = DB::table('comment_table')->where('user_id','=',$result->user_id)->count();
        }
        
        return view('templates.profile',compact('result','ques','ans','comment','ques_cont','ans_cont','comment_cont'));
        }catch(Exception $e){
            abort(404);
        }
    }
    
    public function editshow($name){
$result = DB::table('user_basic')->leftjoin('user_other','user_basic.user_id','=','user_other.user_id')->select('user_basic.*','user_other.*')->where('username','=',$name)->first();
        $top = DB::table('topic_table')->get();
        $re = DB::table('user_other')->select('topics')->where('user_id','=',Auth::user()->user_id)->get();
        $pop = explode(',',$re[0]->topics);
        
        $i = 0;
        if(!empty($re)){
            foreach($pop as $p)
            {
                $r[$i] = DB::table('topic_table')->where('id','=',$p)->first();
                if($r[$i] == null)
                {
                    $re = DB::table('user_other')->select('topics')->where('user_id','=',Auth::user()->user_id)->first();
                    $resu = explode(',',$re->topics);
                    $tid = $p;
                    $pos = array_search($tid,$resu);
                    array_splice($resu, $pos, 1);
                    $ba = implode(',',$resu);
                    DB::table('user_other')->where('user_id','=',Auth::user()->user_id)->update(array('topics'=>$ba));
                }
                    $i++;
            }
        }
             return view('user_edit',compact('result','top','r'));
    }
    
    public function update(Request $request){
        
        $name = $request->input('name');
        $username = $request->input('username');
        $email = $request->input('email');
        $institute = $request->input('institute');
        $user_pic = $request->input('up');
        $specialisation = $request->input('specs');
        
        $user = DB::table('user_basic')->where('username','=',$username)->first();
        DB::table('user_basic')->where('username','=',$username)->update(compact('name','username','email','user_pic'));
        DB::table('user_other')->where('user_id','=',$user->user_id)->update(compact('institute','specialisation'));
    
        session()->flash('status', 'alert alert-success');
        return redirect()->back();
    }
    
    public function deletetopics(Request $request){
        try{
        $re = DB::table('user_other')->select('topics')->where('user_id','=',Auth::user()->user_id)->first();
        $result = explode(',',$re->topics);
        $tid = $request->input('tid');
        $pos = array_search($tid,$result);
        array_splice($result, $pos, 1);
        $ba = implode(',',$result);
        DB::table('user_other')->where('user_id','=',Auth::user()->user_id)->update(array('topics'=>$ba));
           return back()->with('del','1');    
        }
        catch(Exception $e)
        {
            return back();
        }
                                       
    }
    
    public function addtopic(Request $request){
        if($request->input('add') == "")
        {
            return back();
        }
        else{
        $re = DB::table('user_other')->select('topics')->where('user_id','=',Auth::user()->user_id)->first();
            if($re->topics == "")
            {
                DB::table('user_other')->where('user_id','=',Auth::user()->user_id)->update(array('topics'=>$request->input('add')));
        return back()->with('msg','1');   
            }
            else{
        $result = explode(',',$re->topics);
        $v = $request->input('add');
        $tid = explode(',',$v);
        $m = array_merge($tid,$result);
        $m = array_unique($m);
        $ba = implode(',',$m);
        DB::table('user_other')->where('user_id','=',Auth::user()->user_id)->update(array('topics'=>$ba));
        return back()->with('msg','1');   
        }
        }
    }
    
}
