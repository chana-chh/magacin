// Pagination goto
var paginator_goto = document.querySelector("#pgn-goto");
if (paginator_goto !== null) {
    paginator_goto.addEventListener('change', function () {
        location = this.value;
    });
};