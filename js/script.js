document.addEventListener("DOMContentLoaded", function() {
    const formOjol = document.querySelector("form");
    const tombolSubmit = document.querySelector("input[type='submit']");

    if (formOjol) {
        formOjol.addEventListener("submit", function() {
            tombolSubmit.value = "Memproses...";
        });
    }
});