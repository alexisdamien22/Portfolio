const input = document.getElementById("searchInput");

input.addEventListener("input", function () {

    const value = this.value.toLowerCase();
    const cards = document.querySelectorAll(".card");

    cards.forEach(card => {

        const text = card.innerText.toLowerCase();

        if (text.includes(value)) {
            card.classList.remove("hidden");
        } else {
            card.classList.add("hidden");
        }

    });

});