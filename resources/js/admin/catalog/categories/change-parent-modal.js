{
    document.addEventListener('DOMContentLoaded' , () => {
        let changeParentModal = document.getElementById('change-parent-modal')
        let categoryItem = undefined;

        changeParentModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let category_id = button.getAttribute('data-category-id')
            let link = button.getAttribute('data-link')

            categoryItem = changeParentModal.querySelector('li[data-item-id="' + category_id + '"]')
            categoryItem.querySelectorAll('input[name="parent_id"]').forEach((el) => {
                el.disabled = true
            })
            categoryItem.classList.add('text-secondary')

            let form = changeParentModal.querySelector('form')
            form.action = link;
        })

        changeParentModal.addEventListener('hide.bs.modal', function (event) {
            categoryItem.classList.remove('text-secondary')
            categoryItem.querySelectorAll('input[name="parent_id"]').forEach((el) => {
                el.disabled = false
            })
        })
    })
}
