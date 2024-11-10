@extends('home')

@section('content_site')

<div style="padding: 20px; max-width: 800px; margin: auto;">
    <h2>Sobre a Empresa</h2>
    @foreach (explode("\n", $site->Sobre) as $paragrafo)
        @if (trim($paragrafo) !== '')
            <p>{{ $paragrafo }}</p>
        @endif
    @endforeach
</div>
@endsection
