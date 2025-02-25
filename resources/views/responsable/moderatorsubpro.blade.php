@include('layouts.moderatorheader')
<link rel="stylesheet" type="text/css" href="{{ asset('css/moderator/subscribersproposal.css') }}">
<!-- Manage Subscriber Proposals Section -->
<section id="subscriber-proposals">
    <h1>Manage Subscriber Proposals</h1>
    <div class="proposals-table">
        <h2>Subscriber Article Proposals</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Theme</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="proposals-list">
                @if(isset($proposals) && count($proposals) > 0)
                    @foreach($proposals as $proposal)
                        <tr>
                            <td>{{ $proposal->title }}</td>
                            <td>{{ $proposal->theme ? $proposal->theme->name : 'No Theme' }}</td>
                            <td>{{ $proposal->status }}</td>
                            <td>
                                <form action="{{ route('moderator.proposals.destroy', $proposal->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-proposal-btn" data-id="{{ $proposal->id }}">Delete</button>
                                </form>
                                <form action="{{ route('moderator.proposals.proposeEdit', $proposal->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="propose-edit-btn" data-id="{{ $proposal->id }}">Publish</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No proposals available at the moment.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Additional JS if needed
    });
</script>
</body>
</html>
