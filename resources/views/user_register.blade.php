@extends('templates.master') @section('pagetitle','Registration') @section('css')
<style>
    .alert {
        padding: 0;
        margin-bottom: 5px;
        width: 338px;
    }
    
    .panel-heading {
        font-size: 20px;
    }
</style> @stop @section('content')
<div class="row main">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading text-center"> Register </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('user_register') }}" method="post" class="form-group" id="signupForm"> {{csrf_field()}}
                            <label for="username" class="control-label">Enter your Username</label>
                            <input type="text" id="username" name="username" class="form-control" data-toggle="popover" data-content="Username must be unique" data-trigger="focus" data-placement="auto" onblur="checkusername()" maxlength="15" placeholder="Enter Username">
                            <div id="ero" class="alert alert-danger" style="display:none;">Username Already Exists</div>
                            <br>
                            <label for="email">Enter your Email</label>
                            <input type="email" id="emails" name="email" value="" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter Email" data-toggle="popover" onblur="checkemail()" data-content="Example: someone@example.com" data-trigger="focus" data-placement="auto">
                            <div id="erro" class="alert alert-danger" style="display:none;">Email Already Exists</div>
                            <br>
                            <label for="password">Enter your Password</label>
                            <input type="password" id="psw" name="password" data-toggle="popover" data-content="Password must be hard to guess!" maxlength="15" data-trigger="focus" data-placement="auto" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter Password">
                            <br>
                            <label for="user_field">Choose Your Field</label>
                            <select name="user_field" id="field" data-toggle="popover" data-content="Student to ask and Teacher to answer" data-trigger="focus" data-placement="auto" class="form-control{{ $errors->has('user_field') ? ' is-invalid' : '' }}">
                                <option value="" hidden>Select</option>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                            </select> 
                            <br>
                            <br>
                            <p>By clicking on Register you have read and agree to the Terms of Service and Privacy Policy </p>
                            <br>
                            <div class="input-group">
                                <button class="btn btn-primary" value="submit" type="submit">Register</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6"> </div>
                </div>
                <div class="panel-footer"> Already Registered ? <a href="#" class="" onclick="showlogin()">Sign in</a>
                    <br> </div>
            </div>
        </div>
    </div>
</div>@stop @section('script')

   <script src="{{asset('js/user.js')}}"></script>
    <script>
    $(document).ready(function () {
        $("#signupForm").validate({
            rules: {
                username: {
                    required: true
                    , minlength: 5
                    , noSpace: true
                }
                , password: {
                    required: true
                    , minlength: 6
                }
                , email: {
                    required: true
                    , email: true
                }
                , field: "required"
            }
            , messages: {
                username: {
                    required: "Please enter a username"
                    , minlength: "Your username must consist of at least 5 characters"
                    , noSpace: "No space please and don't leave it empty"
                }
                , password: {
                    required: "Please provide a password"
                    , minlength: "Your password must be at least 6 characters long"
                }
                , email: "Please enter a valid email address"
            }
        });
    });
        </script>
 @stop