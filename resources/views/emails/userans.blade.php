@component('mail::message')
<br>&nbsp;Your Question has a new Answer.

@component('mail::button', ['url' => $url])
You can view that by clicking on the following link
@endcomponent

Thanks,<br>
QueryLand
