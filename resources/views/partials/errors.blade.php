@if (count($errors) > 0)
    @php
        /** @var \Illuminate\Support\ViewErrorBag $errors */
    @endphp

    <error-messages :errors="{{ json_encode($errors->get('message')) }}"></error-messages>
@endif