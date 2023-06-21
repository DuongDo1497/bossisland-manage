<td> {{ $entry->action_name }}</td>

<td>
    @if ($entry->admin->role != Status::SUPER_ADMIN)
        <a href="{{ route('admin.staff.index') }}?search={{ $entry->admin->username }}">
            {{ $entry->admin->username }}
        </a>
    @else
        {{ $entry->admin->username }}
    @endif
</td>

<td> {{ showDateTime($entry->created_at) }}</td>
