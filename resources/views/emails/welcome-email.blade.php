@component('mail::message')
# Welcome to ZahiriGram

Now, you are a member of us coders community.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
