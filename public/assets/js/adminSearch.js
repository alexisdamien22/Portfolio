const input = document.getElementById("adminSearch");
const cards = document.querySelectorAll(".admin-card");

input.addEventListener("input", function () {

    const value = this.value.toLowerCase();

    cards.forEach(card => {

        const text = card.innerText.toLowerCase();

        if (text.includes(value)) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }

    });

});