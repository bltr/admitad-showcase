{
    document.addEventListener('DOMContentLoaded', () => {
        let tree = document.querySelectorAll('.tree')

        tree.forEach((el) => {
            el.addEventListener('click', function (event) {
                let toggleButton = event.target.closest('.tree [data-bs-toggle="collapse"]')

                if (toggleButton) {
                    let icon = toggleButton.querySelector('i')
                    icon.classList.toggle('bi-plus')
                    icon.classList.toggle('bi-dash')
                }
            })
        })
    })
}
