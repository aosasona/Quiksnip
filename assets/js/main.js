const heroImage = document.querySelector('#hero-image');

document.addEventListener('mousemove', (e) => {
    const x = e.clientX / window.innerWidth;
    const y = e.clientY / window.innerHeight;
    heroImage.style.transform = `skew(${x * 3}deg, ${y * -3}deg)`;
});