@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifique seu endereço de E-mail') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Um novo link de verificação foi enviado para o seu endereço de E-mail.') }}
                        </div>
                    @endif

                    {{ __('Antes de prosseguir, verifique seu e-mail para um link de verificação.') }}
                    {{ __('Se você não recebeu o E-mail') }}, <a href="{{ route('verification.resend') }}">{{ __('Clique aqui para solicitar outra') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
