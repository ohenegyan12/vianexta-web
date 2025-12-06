const toggle = document.getElementById("toggle");
const dropdownMenu = document.getElementById("drop");

toggle.addEventListener("click", function (e) {
    if (dropdownMenu.classList.contains("d-none")) {
        dropdownMenu.classList.remove("d-none");
    } else if (!dropdownMenu.classList.contains("d-none")) {
        dropdownMenu.classList.add("d-none");
    }
});
