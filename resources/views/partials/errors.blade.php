@php
    /** @var \Illuminate\Support\ViewErrorBag $errors */
@endphp

<error-messages :errors="{{ json_encode($errors->get('message')) }}" v-on:errorHappened="handleError($event)"></error-messages>