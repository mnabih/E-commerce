@component('mail::message')
# Reset Account

Welcome {{ $data['data']  }}


@component('mail::button', ['url' =>  aurl('reset/password/' . $data['token'])])
click Here To Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
