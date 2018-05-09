@extends('templates.master') @section('pagetitle','Who are we | QueryLand') @section('css')
<style>
     
@media (max-width: 516px) {
    .cards {
        width: 125px;
        height: 200px;
    }
     .cont {
        padding: 2px 12px;
         font-size: 11px;
    }
    .cont .h4{
         font-size: 12px;
    }
    .top-m div{
        font-size: 13px;
    }
}      
</style> @stop @section('content')
<div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="bg-c top-m">About us</div>
            <div class="top-m"> <div class="h4">{{$site = \App\Site::where('site_id', 1)->first()->site_description}}</div>
            <div class="h6">KNOWLEDGE SHARING FOR JEE ASPIRANTS</div>
                As we live in the era where most of the work is carried out with the help of computers and the facility of connectivity throughout the world makes it much easier to connect with anyone round the clock. Many students use internet to find out the solutions to their academic problem, but to find a correct solution is not a piece of cake for many, since it is not certain that they are getting verified answer to their problem. The answering forum should be such that most users can use it without facing difficulty in navigating through and can get answers to their problems at any point of time , from trusted professionals or the experts in that domain, so that they can achieve their desired goal efficiently. </div>
        </div>
        <div class="container">
      
        <div class="row size">
            <div class="col-lg-12 top-m">
                <hr>
                <center><span class="h1">Our Team</span></center>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 col-lg-offset-3 col-sm-offset-2 col-md-offset-2 col-xs-offset-1">
                    <div class="cards"> <img src="{{$re[0]->img_content}}" alt="" style="width:100%;">
                        <div class="cont">
                            <div class="h4">Siddhant Tripathi</div>
                            <p>Lead Developer</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
                    <div class="cards"> <img src="{{$re[1]->img_content}}" alt="" style="width:100%;">
                        <div class="cont">
                            <div class="h4">Akash Pandey</div>
                            <p>Assistant Developer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
              
        </div>
</div> @stop