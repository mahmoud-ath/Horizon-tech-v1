@extends('layouts.Officiel-header')

@section('content')
<div class="container">
    <h2>Proposer un article</h2>
    <form action="{{ route('articles.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="theme" class="form-label">Thème</label>
            <select class="form-control" id="theme" name="theme" required>
                @foreach($themes as $theme)
                    <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Published">Publié</option>
                <option value="Pending">En attente</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Image de couverture</label>
            <input type="file" class="form-control" id="cover_image" name="cover_image" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>
@endsection
