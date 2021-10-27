<div class="me-2">
    <input
        type="radio"
        class="form-check-input"
        name="parent_category_id"
        value="{{ $item->id }}"
        onchange="this.form.submit()"
    >
</div>

<div class="me-auto ms-1">{{ $item->name }}</div>
