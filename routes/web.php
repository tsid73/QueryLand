<?php

Route::get('/', 'QuesController@index')->name('welcome');
Route::get('/welcome', 'QuesController@index')->name('welcome');
Route::get('admin/dashboard','AdminController@show')->name('admin.dashboard');
Route::post('admin/dashboard','AdminController@login');
Route::get('/about','BasicController@showabout')->name('who');

Route::group(['prefix' => '/admin/index'], function()
 {
        Route::get('questions','QuesController@adminshow')->name('admin.ques')->middleware('auth:admin');
        Route::delete('questions','QuesController@destroy');
        Route::patch('questions','QuesController@disapprove');
        Route::get('questions/approve/{id}','QuesController@approve');

        Route::get('answers','AnsController@adminshow')->name('admin.ans')->middleware('auth:admin');
        Route::patch('answers','AnsController@approve');
        Route::put('answers','AnsController@disapprove');
        Route::delete('answers','AnsController@destroy');
        Route::post('answers','AnsController@fetch');

        Route::get('users','UserworkController@adminshow')->name('admin.user')->middleware('auth:admin');
        Route::delete('users','UserworkController@destroy');

        Route::get('comments','CommentController@adminshow')->name('admin.comment')->middleware('auth:admin');
        Route::delete('comments','CommentController@destroy');

        Route::get('site','AdminController@site')->name('admin.site')->middleware('auth:admin');
        Route::post('site','AdminController@siteupdate');

        Route::get('link','AdminController@links')->name('admin.link')->middleware('auth:admin');
        Route::post('link','AdminController@linkstore');
        Route::delete('link','AdminController@linkdel');

        Route::get('subject','AdminController@sub')->name('admin.subject')->middleware('auth:admin');
        Route::post('subject','AdminController@substore');
        Route::delete('subject','AdminController@subdel'); 
        Route::patch('subject','AdminController@subupdate');
     
        Route::get('sub_cat','AdminController@subcat')->name('admin.sub_cat')->middleware('auth:admin');
        Route::post('sub_cat','AdminController@subcatstore');
        Route::delete('sub_cat','AdminController@subcatdel');
        Route::patch('sub_cat','AdminController@subcatupdate');
        
        Route::get('topic','AdminController@topicshow')->name('admin.topic')->middleware('auth:admin');
        Route::post('topic','AdminController@topicsave');
        Route::patch('topic','AdminController@topicupdate');
        Route::get('topic/del/{id}','AdminController@topicdelete')->middleware('auth:admin');
        
        Route::get('report','AdminController@reportshow')->name('admin.report')->middleware('auth:admin');
        Route::get('report/delete/{id}','AdminController@reportdel')->middleware('auth:admin');
        Route::get('report/mark/{id}','AdminController@reportmark')->middleware('auth:admin');
    
        Route::post('/user/logout', 'AdminController@logout')->name('admin.logout');
        
        Route::get('/','AdminController@index')->name('admin.index')->middleware('auth:admin'); 
});

Route::patch('/admin/user/update','AdminController@nameupdate');
Route::patch('/admin/user/updates','AdminController@nameupdates');
Route::post('/admin/user/up','AdminController@secupdate');

Route::post('/admin/index/questionsajax','QuesController@approveajax');

Route::get('/user/questions/{id}','BasicController@editques')->name('editques')->middleware('auth');
Route::patch('/user/question','BasicController@updateques');
Route::post('/user/quesdelete','BasicController@deleteques')->middleware('auth');
Route::post('/user/ansdelete','BasicController@deleteans')->middleware('auth');
Route::post('/user/commentdelete','BasicController@deletecomm')->middleware('auth');

Route::post('/user/quesrpt','BasicController@quesrept');
Route::post('/user/ansrpt','BasicController@ansrept');

Route::get('/notification/{id}','BasicController@markread');

Route::get('/notifications/markall','BasicController@markall')->middleware('auth:admin');

Route::get('/subjects/{name}','BasicController@subshow')->name('templates.subject');

Route::get('/user/profile/{name}','ProfileController@show')->name('templates.profile');

Route::get('/user/profile/{name}/edit','ProfileController@editshow')->name('user_edit')->middleware('auth');
Route::post('/user/profile/{name}/edit','ProfileController@update')->middleware('auth');
Route::patch('/user/profile/{name}/edit','ProfileController@addtopic')->middleware('auth');
Route::delete('/user/profile/{name}/edit','ProfileController@deltopic')->middleware('auth');

Route::post('/ques/totalcount','BasicController@totalcount');

Route::post('/user/ans/update','AnsController@ansupdate')->middleware('auth');
Route::post('/user/comm/update','CommentController@commupdate')->middleware('auth');

Route::get('/ask', 'QuesController@askshow')->name('ask')->middleware('auth');
Route::post('/ask','QuesController@store')->name('postques')->middleware('auth');

Route::post('/vote','QuesController@votes')->name('vote');
Route::post('/checkuser','BasicController@checkuser');
Route::post('/checkemail','BasicController@checkemail');

Route::post('/search','QuesController@search')->name('search');
Route::post('/searching','BasicController@search')->name('searching');

Route::post('/ansposted','AnsController@save')->middleware('auth');
Route::delete('/deletetopic','ProfileController@deletetopics')->middleware('auth');
Route::post('/addtopic','ProfileController@addtopic')->middleware('auth');

Route::post('/ques/comments','CommentController@store')->name('comment');

Route::post('/getsubcat','BasicController@getsub');

Route::get('/questions/{slug}','QuesController@show')->name('questions');

Route::post('/q/best','BasicController@best');

Route::post('/admin/dash/pass','AdminController@sendpass')->name('sendpassword');

    //Authentication Routes...
        Route::get('/user/login','Auth\LoginController@showLoginForm')->name('user_login');
        Route::post('/user/login', 'Auth\LoginController@login');
        Route::post('/user/logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
        Route::get('/user/register', 'Auth\RegisterController@showRegistrationForm')->name('user_register');
        Route::post('/user/register', 'Auth\RegisterController@register');

    //Password Reset Routes...
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('pswreset');