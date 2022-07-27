if (document.getElementById('paging_container')) {
    const pagingButtons = document.getElementsByClassName('page_number');

    for (const pagingButton of pagingButtons) {
        pagingButton.addEventListener('click', () => {
            const pagingColorChanged = document.querySelector('.changePagingColor');
            if (pagingColorChanged) {
            pagingColorChanged.classList.remove('changePagingColor');
            }
            pagingButton.classList.add('changePagingColor');
        })
    }
}