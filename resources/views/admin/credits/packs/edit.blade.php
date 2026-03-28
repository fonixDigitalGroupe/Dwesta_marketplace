@extends('layouts.admin')
@section('content')
<div style="max-width:600px;margin:2rem auto;padding:0 1rem;">
    <h1 style="font-size:1.3rem;font-weight:800;margin-bottom:1.5rem;">Modifier le pack — {{ $pack->nom }}</h1>
    @include('admin.credits.packs.form')
</div>
@endsection
