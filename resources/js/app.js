import './bootstrap';


document.addEventListener('DOMContentLoaded', function() {
    // Ajuste la hauteur de tous les textarea au chargement de la page
    setTimeout(() => {
        document.querySelectorAll('.auto-resize').forEach(textarea => {
            autoResize(textarea); // Ajuste la hauteur immédiatement en fonction du contenu initial
            textarea.addEventListener('input', function() {
                autoResize(textarea); // Ajuste la hauteur pendant la saisie
            });
        });
    }, 0); // Délai de 0 millisecondes
});

function autoResize(textarea) {
    textarea.style.height = 'auto'; // Réinitialise la hauteur avant de recalculer
    textarea.style.height = textarea.scrollHeight + 'px'; // Ajuste la hauteur en fonction du contenu
}