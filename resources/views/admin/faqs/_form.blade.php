<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method ?? false)
        @method($method)
    @endif

    <div class="row g-4">
        <div class="col-12">
            <label for="question" class="form-label">Question</label>
            <input id="question" name="question" type="text" value="{{ old('question', $faq->question ?? '') }}"
                class="form-control" autofocus>
            @error('question')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12">
            <label for="answer" class="form-label">Answer</label>
            <textarea id="answer" name="answer" rows="6" class="form-control">{{ old('answer', $faq->answer ?? '') }}</textarea>
            @error('answer')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="sort_order" class="form-label">Sort order</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                value="{{ old('sort_order', $faq->sort_order ?? 0) }}" class="form-control">
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <div class="form-check">
                <input id="faq-status" name="status" type="checkbox" value="1" class="form-check-input"
                    @checked(old('status', $faq->status ?? true))>
                <label for="faq-status" class="form-check-label">Active</label>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save FAQ</button>
    </div>
</form>
