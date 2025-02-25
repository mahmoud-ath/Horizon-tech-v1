<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Form | CodingLab</title>
  <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
</head>
<body>
  <div class="container">
    <!-- Title section -->
    <div class="title">Inscription</div>
    <div class="content">
      <!-- Registration form -->
      <form method="POST" action="{{ route('register') }}">
        @csrf <!-- CSRF Token for Laravel security -->

        <div class="user-details">
          <!-- Input fields -->
          <div class="input-box">
            <span class="details">Nom complet</span>
            <input type="text" name="name" placeholder="Entrez votre nom" value="{{ old('name') }}" required>
          </div>
          <div class="input-box">
            <span class="details">Nom d'utilisateur</span>
            <input type="text" name="user_name" placeholder="Entrez votre nom d'utilisateur" value="{{ old('username') }}" required>
          </div>
          <div class="input-box" style="width: 100%;">
            <span class="details">Email</span>
            <input type="email" name="email" placeholder="Entrez votre email" value="{{ old('email') }}" required>
          </div>

          <div class="input-box" style="width: 100%;">
            <span class="details">Mot de passe</span>
            <input type="password" name="password" placeholder="Entrez votre mot de passe" required>
          </div>
          <div class="input-box" style="width: 100%;">
            <span class="details">Confirmer le mot de passe</span>
            <input type="password" name="password_confirmation" placeholder="Confirmez le mot de passe" required>
          </div>
        </div>

        <!-- Gender selection -->
        <div class="gender-details">
          <span class="gender-title">Sexe</span>
          <div class="category">
            <label for="male">
              <input type="radio" name="gender" value="male" id="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
              <span class="dot"></span>
              <span class="gender">Homme</span>
            </label>
            <label for="female">
              <input type="radio" name="gender" value="female" id="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
              <span class="dot"></span>
              <span class="gender">Femme</span>
            </label>
          </div>
        </div>

        <!-- Submit button -->
        <div class="button">
          <input type="submit" value="Sign Up">
        </div>
      </form>
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

    </div>
  </div>
</body>
</html>
