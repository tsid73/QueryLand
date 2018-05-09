@if(!empty($url))
@component('mail::message')
<br> &nbsp; Your Question has been approved

@component('mail::button', ['url' => $url])
You can view your question by clicking on the following link
@endcomponent

Thanks,<br>
QueryLand

@else
<br> &nbsp; Your Question <b>{{$ques}}</b> has been Disapproved !
 <br> It might be due to one of the following reasons:
 <br> <ul>
     <li>The question wasn't meeting our working field</li>
     <li>Content wasn't appropriate</li>
 </ul>
 <br> <br>
 Note: Kindly read our instructions before posting a question thus saving yours as well as ours precious time. <br>
Thank You,
 QueryLand.
@endif
