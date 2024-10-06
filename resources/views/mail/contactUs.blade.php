<x-mail::message>
    <h2>From: {{ $request->name }}</h2>
    <h3>Subject: {{ $request->subject }}</h3>
    <h3>Email: {{ $request->email }}</h3>

    {!! $request->message !!}

</x-mail::message>
