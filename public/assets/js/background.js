const background = document.querySelector(".background");

const particleCount = 100;

for (let i = 0; i < particleCount; i++) {

    const particle = document.createElement("span");
    particle.classList.add("particle");

    const size = Math.random() * 8 + 2;

    particle.style.width = `${size}px`;
    particle.style.height = `${size}px`;

    particle.style.left = `${Math.random() * 100}%`;
    particle.style.top = `${Math.random() * 100}%`;

    particle.style.setProperty(
        "--opacity",
        (Math.random() * 0.6 + 0.25).toFixed(2)
    );

    particle.style.setProperty("--x1", `${Math.random()*40-20}px`);
    particle.style.setProperty("--y1", `${Math.random()*40-20}px`);

    particle.style.setProperty("--x2", `${Math.random()*80-40}px`);
    particle.style.setProperty("--y2", `${Math.random()*80-40}px`);

    particle.style.setProperty("--x3", `${Math.random()*40-20}px`);
    particle.style.setProperty("--y3", `${Math.random()*40-20}px`);

    const fadeDuration = Math.random() * 18 + 18;
    const moveDuration = Math.random() * 30 + 30;

    particle.style.animationDuration =
        `${fadeDuration}s, ${moveDuration}s`;

    particle.style.animationDelay =
        `${Math.random()*20}s, ${Math.random()*20}s`;

    particle.style.filter =
        `blur(${Math.random()*4+1}px)`;

    particle.style.boxShadow =
        `0 0 ${size*4}px rgba(180,220,255,.8),
         0 0 ${size*8}px rgba(120,180,255,.35)`;

    background.appendChild(particle);
}