document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    form.addEventListener("submit", () => {
        const btn = form.querySelector("button");
        btn.innerText = "Ingresando...";
        btn.disabled = true;
    });
});