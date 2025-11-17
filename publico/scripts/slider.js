// Contenedor del slider de carreras
const slider = document.querySelector('.carreras__lista');

// Variables de control para arrastrar con mouse o táctil
let estaAbajo = false; // Indica si el usuario mantiene presionado
let inicioX = 0;       // Posición inicial del cursor/táctil
let scrollInicial = 0; // Posición inicial del scroll

// Activa o desactiva el estado de "arrastrando"
const activar = (estado) => {
  estaAbajo = estado;
  slider.classList.toggle('activado', estado);
};

// Obtiene la posición X del cursor o del toque táctil
const obtenerPosX = (e) => e.touches ? e.touches[0].pageX : e.pageX;

// Inicia el arrastre del slider
const iniciarDeslizamiento = (e) => {
  activar(true);
  inicioX = obtenerPosX(e) - slider.offsetLeft;
  scrollInicial = slider.scrollLeft;
};

// Mueve el slider mientras el usuario arrastra
const moverDeslizamiento = (e) => {
  if (!estaAbajo) return;
  e.preventDefault();
  const x = obtenerPosX(e) - slider.offsetLeft;
  const desplazamiento = (x - inicioX) * 2; // Multiplica para mayor velocidad
  slider.scrollLeft = scrollInicial - desplazamiento;
};

// Finaliza el arrastre
const detenerDeslizamiento = () => activar(false);

// Eventos para control con mouse
slider.addEventListener('mousedown', iniciarDeslizamiento);
slider.addEventListener('mousemove', moverDeslizamiento);
slider.addEventListener('mouseup', detenerDeslizamiento);
slider.addEventListener('mouseleave', detenerDeslizamiento);

// Eventos para control táctil
slider.addEventListener('touchstart', iniciarDeslizamiento, { passive: false });
slider.addEventListener('touchmove', moverDeslizamiento, { passive: false });
slider.addEventListener('touchend', detenerDeslizamiento);

// Botones de navegación del slider
const botonIzquierda = document.querySelector('.carreras__boton--izquierda');
const botonDerecha = document.querySelector('.carreras__boton--derecha');

// Cantidad de píxeles que se mueve al hacer clic en los botones
const desplazamientoBoton = 450;

// Función para desplazar el slider con los botones
const moverSlider = (direccion) => {
  slider.scrollBy({
    left: direccion * desplazamientoBoton,
    behavior: 'smooth' // Desplazamiento animado
  });
};

// Eventos de click/touch para los botones
['mousedown', 'touchstart'].forEach(evento => {
  botonIzquierda.addEventListener(evento, () => moverSlider(-1));
  botonDerecha.addEventListener(evento, () => moverSlider(1));
});
