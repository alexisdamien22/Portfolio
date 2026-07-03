const background = document.querySelector(".background");

for (let i = 0; i < 40; i++) {

    const particle = document.createElement("span");
    particle.classList.add("particle");

    const size = Math.random() * 6 + 2;

    particle.style.width = `${size}px`;
    particle.style.height = `${size}px`;

    particle.style.left = `${Math.random() * 100}%`;
    particle.style.top = `${Math.random() * 100}%`;

    particle.style.animationDelay = `${Math.random() * 20}s`;

    particle.style.animationDuration =
        `${18 + Math.random() * 20}s, ${25 + Math.random() * 20}s`;

    background.appendChild(particle);
}