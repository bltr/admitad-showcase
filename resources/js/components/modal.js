{
    document.addEventListener('DOMContentLoaded' , () => {
        let choiceParentModal = document.getElementById('choiceParentModal')
        let categoryItem = undefined;

        choiceParentModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let category_id = button.getAttribute('data-category-id')
            let link = button.getAttribute('data-link')

            categoryItem = choiceParentModal.querySelector('li[data-item-id="' + category_id + '"]')
            categoryItem.querySelectorAll('input[name="parent_category_id"]').forEach((el) => {
                el.disabled = true
            })
            categoryItem.classList.add('text-secondary')

            let form = choiceParentModal.querySelector('form')
            form.action = link;
        })

        choiceParentModal.addEventListener('hide.bs.modal', function (event) {
            categoryItem.classList.remove('text-secondary')
            categoryItem.querySelectorAll('input[name="parent_category_id"]').forEach((el) => {
                el.disabled = false
            })
        })
    })
}
