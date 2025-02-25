@include('layouts.Officiel-header')
<link rel="stylesheet" href="{{ asset('css/accueil/contact-us.css') }}">
<main class="contact-page">
    <h1>Contact Us</h1>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="contact-info">
        <h2>Contact Information</h2>
        <p>Si vous avez des questions, des commentaires ou des demandes de renseignements, n’hésitez pas à nous contacter via ce qui suit :</p>
        <ul>
            <li>Email: <a href="mailto:contact@techhorizons.ma">contact@techhorizons.ma</a></li>
            <li>Téléphone: <a href="tel:+212500000000">+212 500 000 000</a></li>
            <li>Addresse: Tech Horizons Maroc<br>
                Avenue des Technologies,<br>
                Quartier Innovation,<br>
                Casablanca 20200,<br>
                Maroc </li>
        </ul>
    </div>
    <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit" class="btn">Send Message</button>
    </form>
</main>

@include('layouts.Officiel-footer')
</body>

</html>