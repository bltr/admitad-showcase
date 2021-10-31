<!-- Modal -->
<div class="modal" id="choiceParentModal" tabindex="-1">
    <div class="modal-dialog  modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content h-100">

            <div class="modal-header">
                <h5 class="modal-title">Выбрать родительскую категорию</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST">
                    @csrf

                    <div class="d-flex">
                        <div class="ms-5">
                            <input
                                type="radio"
                                class="form-check-input"
                                name="parent_category_id"
                                value="{{ $root->id }}"
                                onchange="this.form.submit()"
                            >
                        </div>
                        <div class="ms-2 me-auto ps-1 mb-2">Без родителя</div>
                    </div>

                    @component('components.tree', ['items' => $categories, 'id' => 'modal'])
                        @scopedSlot('itemTemplate', ($item))
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
                        @endScopedSlot
                    @endcomponent

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
            </div>

        </div>
    </div>
</div>
