@php
    /** @var \Illuminate\Support\ViewErrorBag $errors */

    $messages = [];
    foreach ($errors->all() as $error) {
        $messages[] = [
            'text' => $error,
            'type' => 'error',
        ];
    }

    if (session('status')) {
        $messages[] = [
            'text' => session('status'),
            'type' => 'success',
        ];
    }

@endphp

<flash-messages :messages="{{ json_encode($messages) }}"></flash-messages>