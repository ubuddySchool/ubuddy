@foreach ($enquiries as $enquiry)
<tr>
    <td>{{ $enquiry->id }}</td>
    <td>{{ $enquiry->school_name }}</td>
    <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
    <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
    <td>
        @if ($enquiry->status == 0)
        <span class="badge bg-warning">Running</span>
        @elseif ($enquiry->status == 1)
        <span class="badge bg-success">Converted</span>
        @elseif ($enquiry->status == 2)
        <span class="badge bg-danger">Rejected</span>
        @endif
    </td>
</tr>
@endforeach
