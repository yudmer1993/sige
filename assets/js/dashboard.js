document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll('.link');
    const frame = document.getElementById('frame');

    links.forEach(link => {
        link.addEventListener('click', function(e){
            e.preventDefault();
            frame.src = this.href;
        });
    });
});