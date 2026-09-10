@include('admin.partials.form-errors')
<form method="POST" action="{{ $action }}" class="row g-4">
    @csrf @if ($method ?? false)
        @method($method)
    @endif
    <div class="col-12"><label class="form-label">Question</label><input name="question"
            value="{{ old('question', $faq->question ?? '') }}" class="form-control" required></div>
    <div class="col-12"><label class="form-label">Answer</label>
        <textarea name="answer" rows="6" class="form-control" required>{{ old('answer', $faq->answer ?? '') }}</textarea>
    </div>
    <div class="col-md-6"><label class="form-label">Sort order</label><input type="number" min="0"
            name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" class="form-control"></div>
    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check"><input type="checkbox" name="status" value="1" class="form-check-input"
                id="faq-status" @checked(old('status', $faq->status ?? true))><label class="form-check-label"
                for="faq-status">Active</label></div>
    </div>
    <div class="col-12 d-flex gap-2"><button class="btn btn-primary"><i class="bi bi-check-lg"></i> Save</button><a
            href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
</form>
