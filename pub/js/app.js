// Pagination goto
var paginator_goto = document.querySelector("#pgn-goto");
if (paginator_goto !== null) {
    paginator_goto.addEventListener('change', function () {
        location = this.value;
    });
};

// Seatch
function liveSearch() {
    // Locate the card elements
    let cards = document.querySelectorAll('.pretraga');
    // Locate the search input
    let search_query = document.getElementById("searchbox").value;
    // Loop through the cards
    for (var i = 0; i < cards.length; i++) {
        // If the text is within the card...
        if (cards[i].innerText.toLowerCase().includes(search_query.toLowerCase())) {
            cards[i].classList.remove("d-none");
        } else {
            cards[i].classList.add("d-none");
        }
    }
}

let typingTimer;
let typeInterval = 500; // Half a second
let searchInput = document.getElementById('searchbox');
let ponisti = document.getElementById('ponisti-pretragu');
searchInput.addEventListener('keyup', () => {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(liveSearch, typeInterval);
});

ponisti.addEventListener('click', () => {
    searchInput.value = '';
    liveSearch();
});

