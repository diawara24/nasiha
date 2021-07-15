window.onload = () => {
    if(document.querySelector("#toast") != null){
        let element = document.querySelector("#toast");
        launch_toast(element);
    }
    document.addEventListener("scroll", scrolled);
    document.querySelector("#archives").addEventListener("change", loadArchive);
    let links = document.querySelectorAll("a[target='_blank']");
    if (links !== null) {
        for (link of links) {
            link.title = 'S\'ouvre dans une nouvelle fenêtre'
        }
    }
    document.querySelector("#search-close").addEventListener("click", function () {
        document.querySelector("#search-container").classList.toggle('shown');
    });
    document.querySelector("#search").addEventListener("click", function () {
        document.querySelector("#search-container").classList.toggle('shown');
        document.querySelector("#keywords").focus();
    })
    document.querySelector("#toggle-button").addEventListener("click", toggleMenu);
    document.querySelectorAll(".navbar-link").forEach(element => {
        element.addEventListener("click", function () {
            if (document.querySelector("#main-menu").classList.contains("shown")) {
                toggleMenu();
            }
        });
    });
}

function toggleMenu() {
    document.querySelector("#main-menu").classList.toggle("shown");
}


function scrolled() {
    // Calcul de la hauteur "utile" du document
    let hauteur = document.documentElement.scrollHeight - window.innerHeight

    // Récupération de la position verticale
    let position = window.scrollY

    // Récupération de la largeur de la fenêtre
    let largeur = document.documentElement.clientWidth

    // Calcul de la largeur de la barre
    let barre = position / hauteur * largeur

    // Modification du CSS de la barre
    document.querySelector("#progress").style.width = barre + "px"
}

function loadArchive() {
    window.location.href = this.value;
}


function launch_toast(element) {
    element.className = "show";
    setTimeout(function(){ element.className = element.className.replace("show", ""); }, 5000);
}