<?php

namespace App\Http\Controllers;

use App\Admin;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller
{
    
    use AuthenticatesAdmin;
    
    protected $redirectTo = '/admin/index';

    
    public function index()
    {
        $ques = DB::table('ques_table')->count();
        $user = DB::table('user_basic')->count();
        $ans = DB::table('ans_table')->count();
        $comm = DB::table('comment_table')->count();
        $this->check_unread();
        return view('admin.index',['ques'=>$ques,'ans'=>$ans,'user'=>$user,'comm'=>$comm]);
    }

    public function check_unread(){
        DB::table('notifications')->where('created_at','<',Carbon::now('Asia/Kolkata')->subDays(15))->delete();
    }
    
    public function site(){
        $result = DB::table('site_table')->first();
        $this->check_unread();
        if(!empty($result)){
            return view('admin.site',compact('result'));
        }
    } 
 
    public function sub(){
        $result = DB::table('subject_table')->get();
        $this->check_unread();
        if(!empty($result)){
            return view('admin.subject',compact('result'));
        }
    } 
    
    public function subcat(){
        $result = DB::table('sub_category')->leftjoin('subject_table','sub_category.subject_id','subject_table.subject_id')->select('sub_category.*','subject_table.subject_id','subject_table.subj_name')->get();
        $re = DB::table('subject_table')->get();
        $this->check_unread();
        if(!empty($result)){
            return view('admin.sub_cat',compact('result','re'));
        }
    }

    public function topicshow(){
        $result = DB::table('topic_table')->get();
        if(!empty($result)){
            return view('admin.topic',compact('result'));
        }
    }
    
    public function reportshow(){
        $result = DB::table('report')->whereNull('mark')
            ->leftjoin('user_basic','user_basic.user_id','report.user_id')->select('report.*','user_basic.username')
            ->paginate(15);
        if(!empty($result)){
            return view('admin.report',compact('result'));
        }
    }
    
    public function reportdel($id){
        DB::table('report')->where('rid',$id)->delete();
        return back();
    } 
    public function reportmark($id){
        DB::table('report')->where('rid',$id)->update(array('mark'=>Carbon::now('Asia/Kolkata')));
        return back();
    }
    
    public function topicsave(Request $request){
        $top = $request->input('tops');
        $tag = $request->input('tag');
        $t = Carbon::now('Asia/Kolkata');
        try{
        DB::table('topic_table')->insert(array('topics'=>$top,'tags'=>$tag,'created_at'=>$t));
        }
        catch(Exception $e)
        {
            return back()->with('msg','1');   
        }
        return back()->with('msg','0');
    }
    public function topicdelete($id){
        DB::table('topic_table')->where('id',$id)->delete();
        return back()->with('del','0');
    }
    public function topicupdate(Request $request){
        $top = $request->input('top');
        $tag = $request->input('tags');
        $id = $request->input('topid');
        $t = Carbon::now('Asia/Kolkata');
        try{
        DB::table('topic_table')->where('id',$id)->update(array('topics'=>$top,'tags'=>$tag,'updated_at'=>$t));
        }
        catch(Exception $e)
        {
            return back()->with('msg','1');   
        }
        return back()->with('msg','0');
        
    }
    
    protected function sendFailedLoginResponse(Request $request)
    {
        $error= 1;
        return redirect()->route('admin.dashboard')->with('error',$error);
    }
    
    
    public function substore(Request $request){
        try
        {
            $title = $request->input('title');
            $tags = $request->input('tags');
            $z = DB::table('subject_table')->insert(array('subj_name'=>$title,'tag'=>$tags));
        }
        catch(Exception $e)
        {
            return back()->with('msg',1);
        }
            return back()->with('msg',0);         
    }
    
    public function subcatstore(Request $request)
    {
        try
        {
         DB::table('sub_category')->insert(array('subject_id'=>$request->input('subj'),'category'=>$request->input('cat')));   
        }
        catch(Exception $e)
        {
            return back()->with('msg',1);
        }
            return back()->with('msg',0);                       
    }
    
    public function subdel(Request $request){
        try{
        $id = $request->input('id');
        DB::table('subject_table')->where('subject_id','=',$id)->delete();
        }
        catch(Exception $e)
        {
            session(['msgs' => 1]);
            return \Redirect::to($request->path());
        }
            return \Redirect::to($request->path())->with('msgs',0);
    }
     public function subcatdel(Request $request){
        $id = $request->input('id');
        $z = DB::table('sub_category')->where('sub_cat','=',$id)->delete();
        return \Redirect::to($request->path());
    }
    
     public function siteupdate(Request $request){
        $id = $request->input('id');
         if($id == "")
         {
    $id = DB::table('site_table')->insertGetId(array('site_name'=>'some','site_description'=>'some','footer'=>'some'),'site_id');
         }
        $desc = $request->input('desc');
        $footer = $request->input('footer');
         $logo = $request->input('up');
        $title = $request->input('title');
         $update = Carbon::now('Asia/Kolkata');
   DB::table('site_table')->where('site_id','=',$id)->update(array('site_name'=>$title,'site_description'=>$desc,'footer'=>$footer,'logo'=>$logo,'updated_at'=>$update));
         return back()->with('status','alert alert-success');
    }
    
    public function subupdate(Request $request)
    {
        try{
        DB::table('subject_table')->where('subject_id','=',$request->input('sid'))
            ->update(array('subj_name'=>$request->input('sub'),'tag'=>$request->input('tag')));
        }
        catch(Exception $e)
        {
            return back()->with('msg',1);
        }
            return back()->with('msg',0);         

    }
    
    public function subcatupdate(Request $request)
    {
        try{
        DB::table('sub_category')->where('sub_cat','=',$request->input('catid'))
            ->update(array('subject_id'=>$request->input('subj'),'category'=>$request->input('cat')));
        }
        catch(Exception $e)
        {
            return back()->with('msg',1);
        }
            return back()->with('msg',0);         

    }
    

    public function show(Admin $admin)
    {
        return view('admin.dashboard');
        
    }
    
    public function sendpass(Request $request){
        $email = $request->input('email');
        $sques = $request->input('sques');
        $sans = $request->input('sans');
        
        $result = DB::table('admin_extra')->where('email',$email)->first();
        $a = DB::table('admin_table')->select('admin_id','username')->where('admin_id',$result->admin_id)->first();
        if($result->sques == $sques){
            if($result->sans == $sans){
                return view('admin.update')->with(['user'=>$a->username,'user_id'=>$a->admin_id]);
            }
            else{
                return back()->with('er','1');
            }
        }
        else{
            return back()->with('er','1');
        }
    } 
    
    public function secupdate(Request $request){
        try{
        $email = $request->input('email');
        $sques = $request->input('sques');
        $sans = $request->input('sans');
        $id = $request->input('id');
        
        DB::table('admin_extra')->where('admin_id',$id)->update(array('email'=>$email,'sques'=>$sques,'sans'=>$sans));
                return back();
        }catch(Exception $e)
        {
            return back();
        }
        
    }
    
    public function nameupdate(Request $request)
    {
        if($request->psw=="")
        {
        DB::table('admin_table')->where('admin_id','=',$request->input('id'))->update(array('username'=>$request->input('user')));
        return back();
        }
        else
        {
            $psw = Hash::make($request->input('psw'));
            DB::table('admin_table')->where('admin_id','=',$request->input('id'))->update(array('username'=>$request->input('user'),'password'=>$psw));
        return back();
        }
        
    } 
    public function nameupdates(Request $request)
    {
        if($request->psw=="")
        {
        DB::table('admin_table')->where('admin_id','=',$request->input('id'))->update(array('username'=>$request->input('user')));
        return view('admin.dashboard');
        }
        else
        {
            $psw = Hash::make($request->input('psw'));
            DB::table('admin_table')->where('admin_id','=',$request->input('id'))->update(array('username'=>$request->input('user'),'password'=>$psw));
        return view('admin.dashboard');
        }
        
    }
    
    public static function checkapp($id,$nid){
        $var = DB::table('ques_extra')->select('status')->where('ques_id','=',$id)->first();
        if(empty($var)){
            DB::table('notifications')->where('id','=',$nid)->delete();
            return;
        }
        if($var->status == "1")
        {
            return true;
        }
        else
            return false;
        
    }
    
    public static function anscount(){
        $re = DB::table('ans_extra')->where('status','0')->count();
        return $re;
    }
    
    public static function reportcount(){
        $re = DB::table('report')->whereNull('mark')->count();
        return $re;
    }

}