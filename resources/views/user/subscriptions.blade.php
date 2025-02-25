@include('layouts.userheader')
<link rel="stylesheet" href="{{ asset('css/user/subscription.css') }}">

<section id="subscription">
    <h1>Subscription</h1>
    <p>Manage your subscription and billing details.</p>

    <table class="subscription-table">
        <thead>
            <tr>
                <th>Theme</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($themes) && $themes->count() > 0)
            @foreach($themes as $theme)
            <tr>
                <td>{{ $theme->name }}</td>
                <td id="status-{{ $theme->id }}">
                    @if($theme->status) Subscribed @else Not Subscribed @endif
                </td>
                <td>
                    <button class="subscribe-btn {{ $theme->status ? 'subscribed' : 'not-subscribed' }}"
                        id="subscribe-{{ $theme->id }}"
                        data-status="@if($theme->status) Unsubscribe @else Subscribe @endif"
                        onclick="toggleSubscription('{{ $theme->id }}')">
                        @if($theme->status) Unsubscribe @else Subscribe @endif
                    </button>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="3">No themes available.</td>
            </tr>
            @endif
        </tbody>
    </table>

</section>

<script>
function toggleSubscription(themeId) {
    fetch('{{ route('user.toggleSubscription') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({theme: themeId})
    }).then(response => response.json()).then(data => {
        if (data.success) {
            let statusElement = document.getElementById('status-' + themeId);
            let buttonElement = document.getElementById('subscribe-' + themeId);

            if (statusElement.innerText === 'Subscribed') {
                statusElement.innerText = 'Not Subscribed';
                buttonElement.innerText = 'Subscribe';
                buttonElement.setAttribute('data-status', 'Subscribe');
                buttonElement.classList.remove('subscribed');
                buttonElement.classList.add('not-subscribed');
            } else {
                statusElement.innerText = 'Subscribed';
                buttonElement.innerText = 'Unsubscribe';
                buttonElement.setAttribute('data-status', 'Unsubscribe');
                buttonElement.classList.remove('not-subscribed');
                buttonElement.classList.add('subscribed');
            }
        }
    });
}
</script>