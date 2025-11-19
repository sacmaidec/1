// === Sidebar Toggle Function ===
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar-wrapper");
    sidebar.classList.toggle("active");
}

// === Event Listeners ===
document.addEventListener("DOMContentLoaded", () => {
    // Sidebar button click
    const toggleButton = document.getElementById("menu-toggle");
    if (toggleButton) {
        toggleButton.addEventListener("click", toggleSidebar);
    }

    // Navigation page switching
    document.querySelectorAll(".list-group-item[data-page]").forEach((btn) => {
        btn.addEventListener("click", function () {
            document.querySelectorAll(".list-group-item").forEach((link) => link.classList.remove("active"));
            this.classList.add("active");

            document.querySelectorAll(".page-section").forEach((sec) => sec.classList.add("d-none"));
            const page = this.getAttribute("data-page");
            document.getElementById(page + "-page").classList.remove("d-none");
        });
    });

    // Applicant search
    const searchInput = document.getElementById("searchApplicant");
    if (searchInput) {
        searchInput.addEventListener("keyup", function () {
            const filter = this.value.toLowerCase();
            document.querySelectorAll("#applicant-table tr").forEach((row) => {
                const name = row.children[0].textContent.toLowerCase();
                row.style.display = name.includes(filter) ? "" : "none";
            });
        });
    }
});


