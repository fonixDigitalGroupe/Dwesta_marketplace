@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pt-4 text-center">
                    <h4 class="fw-bold">Vérifiez votre adresse email</h4>
                </div>

                <div class="card-body p-4 text-center">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif


                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            Renvoyer l'email de vérification
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
