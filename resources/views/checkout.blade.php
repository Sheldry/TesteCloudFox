@extends('layouts.master')

@section('page-title', 'Obrigado')
@section('page-content')
    
    <div class="container py-4">

        <!-- Mensagem de sucesso -->
        @if(session()->exists('status'))
            <div class="alert p-4 mb-4 alert-{{ session()->get('color') }}">
                <h3 class="alert-heading">{{ session()->get('title') }}</h3>
                @if(!empty(session()->get('message')))
                    <p class="mb-0">{{ session()->get('message') }}</p>
                @endif
            </div>

            @if(!empty(session()->get('url')))
                <a class="btn btn-primary" href="{{ session()->get('url') }}" target="_blank" role="button">Boleto para pagamento</a>
            @endif
        @endif
    </div>

@endsection