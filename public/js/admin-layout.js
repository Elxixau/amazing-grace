document.addEventListener("DOMContentLoaded", function () {
        const toggler = document.querySelector(".notify-toggler");
        const dropdown = document.querySelector(".dropdown-notify");

        if (toggler && dropdown) {
            toggler.addEventListener("click", function (e) {
                e.stopPropagation();
                dropdown.classList.toggle("show");
            });

            document.addEventListener("click", function () {
                dropdown.classList.remove("show");
            });

            dropdown.addEventListener("click", function (e) {
                e.stopPropagation();
            });
        }

        const refreshBtn = document.getElementById("refress-button");
        if (refreshBtn) {
            refreshBtn.addEventListener("click", function () {
                location.reload();
            });
        }
    });