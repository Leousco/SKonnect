document.addEventListener("DOMContentLoaded", function () {

    // Load Navbar
    loadComponent("navbar", "../components/navbar.html");

    // Load Footer
    loadComponent("footer", "../components/footer.html");

    function loadComponent(id, file) {
        fetch(file)
            .then(response => response.text())
            .then(data => {
                document.getElementById(id).innerHTML = data;
                if (id === "navbar") initializeNavbar();
            })
            .catch(error => console.error("Error loading component:", error));
    }

    function initializeNavbar() {
        const navbarToggle = document.getElementById("navbarToggle");
        const navbarMenu = document.getElementById("navbarMenu");

        if (navbarToggle && navbarMenu) {
            navbarToggle.addEventListener("click", function () {
                navbarMenu.classList.toggle("active");
            });
        }

        // Highlight active page
        const currentPage = window.location.pathname.split("/").pop();
        document.querySelectorAll(".nav-link").forEach(link => {
            if (link.getAttribute("href") === currentPage) {
                link.classList.add("active");
            }
        });
    }

    // Counter animation
    const counters = document.querySelectorAll(".counter");

    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute("data-target");
            const count = +counter.innerText;
            const increment = target / 100;

            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target + "+";
            }
        };
        updateCount();
    });

});
