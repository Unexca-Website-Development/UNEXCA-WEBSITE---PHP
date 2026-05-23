/**
 * slider.js - UNEXCA Portal Web
 * 
 * Implementa un sistema de desplazamiento por arrastre (Drag and Scroll)
 * optimizado para mouse y pantallas táctiles.
 */

function crearSlider(selector, btnIzq = null, btnDer = null) {
    const contenedor = document.querySelector(selector);
    if (!contenedor) return;

    let estaPresionado = false;
    let puntoInicioX;
    let scrollIzquierdaInicial;

    // --- EVENTOS DE MOUSE ---
    contenedor.addEventListener('mousedown', (e) => {
        // No arrastrar si es un clic en botón o enlace
        if (e.target.closest('a') || e.target.closest('button')) return;
        
        estaPresionado = true;
        contenedor.classList.add('activado');
        puntoInicioX = e.pageX;
        scrollIzquierdaInicial = contenedor.scrollLeft;
        
        // Desactivar selección de texto y drag nativo
        contenedor.style.cursor = 'grabbing';
        contenedor.style.userSelect = 'none';
        e.preventDefault();
    });

    window.addEventListener('mouseup', () => {
        estaPresionado = false;
        if (contenedor) {
            contenedor.classList.remove('activado');
            contenedor.style.cursor = 'grab';
            contenedor.style.removeProperty('user-select');
        }
    });

    contenedor.addEventListener('mousemove', (e) => {
        if (!estaPresionado) return;
        e.preventDefault();
        
        const x = e.pageX;
        const desplazamiento = (x - puntoInicioX) * 2; // Factor de velocidad
        contenedor.scrollLeft = scrollIzquierdaInicial - desplazamiento;
    });

    // --- EVENTOS TÁCTILES (Móviles) ---
    contenedor.addEventListener('touchstart', (e) => {
        if (e.target.closest('a') || e.target.closest('button')) return;
        puntoInicioX = e.touches[0].pageX;
        scrollIzquierdaInicial = contenedor.scrollLeft;
    }, { passive: true });

    contenedor.addEventListener('touchmove', (e) => {
        const x = e.touches[0].pageX;
        const desplazamiento = (x - puntoInicioX) * 1.5;
        contenedor.scrollLeft = scrollIzquierdaInicial - desplazamiento;
    }, { passive: true });

    // --- BOTONES (Si existen) ---
    if (btnIzq && btnDer) {
        const bIzq = document.querySelector(btnIzq);
        const bDer = document.querySelector(btnDer);
        if (bIzq && bDer) {
            bIzq.onclick = (e) => { e.preventDefault(); contenedor.scrollBy({ left: -400, behavior: 'smooth' }); };
            bDer.onclick = (e) => { e.preventDefault(); contenedor.scrollBy({ left: 400, behavior: 'smooth' }); };
        }
    }
}

// Inicialización limpia
document.addEventListener('DOMContentLoaded', () => {
    // 1. Carreras
    crearSlider('.carreras__lista', '.carreras__boton--izquierda', '.carreras__boton--derecha');
    
    // 2. Noticias
    crearSlider('.noticias__lista');
    
    // 3. Sedes (Núcleos)
    crearSlider('.componente-nucleos__grid');
});
