@php
    /** @var \Illuminate\Support\ViewErrorBag $errors */
@endphp

<flash-messages :errors="{{ json_encode($errors->get('message')) }}" v-on:errorHappened="handleError($event)"></flash-messages>