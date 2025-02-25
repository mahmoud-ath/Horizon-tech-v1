@extends('layouts.Officiel-header')

@section('content')
<div class="container">
    <h2>{{ $article->title }}</h2>
    <p><strong>Thème:</strong> {{ $article->theme->name }}</p>
    <p><strong>Auteur:</strong> {{ $article->user->name }}</p>
    <p><strong>Statut:</strong> {{ $article->status }}</p>
    <p><strong>Publié le:</strong> {{ $article->published_date->format('d/m/Y') }}</p>

    @if($article->imagepath)
        <div>
            <img src="{{ asset($article->imagepath) }}" alt="Image de couverture" class="img-fluid">
        </div>
    @endif

    <div class="mt-4">
        <p>{!! nl2br(e($article->content)) !!}</p>
    </div>

    <a href="{{ route('articles.create') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
