const link = document.getElementById('link')
const burger = document.getElementById('burger')
const ul = document.querySelector('ul')

link.addEventListener('click', function (event) {
    event.preventDefault()
    burger.classList.toggle('open')
    ul.classList.toggle('open')
})

function search_GooDeal() {
    let search = document.getElementById('search').value;
    if (search) {
        window.location.href = 'announcements?search=' + search;
    }
}
