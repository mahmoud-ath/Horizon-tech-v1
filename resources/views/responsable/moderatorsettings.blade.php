<!-- Sections -->
@include('layouts.moderatorheader')
<link rel="stylesheet" href="{{ asset('css/moderator/settings.css') }}">
<section id="settings" class="settings-section">
    <h2 class="settings-title">Settings</h2>
    <form id="settings-form" class="settings-form" method="POST" action="{{ route('moderator.profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="settings-form-group">
        <label for="username" class="settings-label">Username :</label>
        <input type="text" name="username" id="username" class="settings-input" placeholder="your new username" required value="{{ auth()->user()->name }}" />
    </div>

    <div class="settings-form-group">
        <label for="password" class="settings-label">password:</label>
        <input type="password" name="password" id="password" class="settings-input" placeholder="password" />
    </div>
<!--
    <div class="settings-form-group">
        <label for="user_image" class="settings-label">Your avatar :</label>
        <input type="file" name="user_image" id="user_image" class="settings-file-input" accept="image/*" />
    </div>
-->
    <button type="submit" class="settings-submit-btn">Save</button>
</form>

</section>
</body>
</html>
