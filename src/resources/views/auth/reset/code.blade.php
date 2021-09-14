@component('mail::message', ['heading' => ''])
# @lang('Your password change code'):

@component('mail::panel', ['class' => 'text-code'])
{{ implode(' ', $code) }}
@endcomponent

@endcomponent

