<form method="POST" action="{{ $action }}" class="d-inline"
    onsubmit="return confirm('Are you sure you want to delete this record?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
</form>
