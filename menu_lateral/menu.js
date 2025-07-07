const menuToggle = document.getElementById("menu-toggle");
const menu = document.getElementById("menu");

function handleMenuToggle() {
    if (window.innerWidth > 750) {
        menu.classList.toggle("expanded");
    }
}

if (window.innerWidth > 750) {
    menuToggle.addEventListener("click", handleMenuToggle);
}
