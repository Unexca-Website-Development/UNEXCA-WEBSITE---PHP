const slider = document.querySelector('.carreras__lista');
let estaAbajo = false;
let inicioX = 0;
let scrollInicial = 0;

const activar = (estado) => {
  estaAbajo = estado;
  slider.classList.toggle('activado', estado);
};

const obtenerPosX = (e) =>
  e.touches ? e.touches[0].pageX : e.pageX;

const iniciarDeslizamiento = (e) => {
  activar(true);
  inicioX = obtenerPosX(e) - slider.offsetLeft;
  scrollInicial = slider.scrollLeft;
};

const moverDeslizamiento = (e) => {
  if (!estaAbajo) return;
  e.preventDefault();
  const x = obtenerPosX(e) - slider.offsetLeft;
  const desplazamiento = (x - inicioX) * 2;
  slider.scrollLeft = scrollInicial - desplazamiento;
};

const detenerDeslizamiento = () => activar(false);

// Soporte para mouse
slider.addEventListener('mousedown', iniciarDeslizamiento);
slider.addEventListener('mousemove', moverDeslizamiento);
slider.addEventListener('mouseup', detenerDeslizamiento);
slider.addEventListener('mouseleave', detenerDeslizamiento);

// Soporte para tactil
slider.addEventListener('touchstart', iniciarDeslizamiento, { passive: false });
slider.addEventListener('touchmove', moverDeslizamiento, { passive: false });
slider.addEventListener('touchend', detenerDeslizamiento);


// Botones
const botonIzquierda = document.querySelector('.carreras__boton--izquierda');
const botonDerecha = document.querySelector('.carreras__boton--derecha');

// Estos son los pixeles que desplaza
const desplazamientoBoton = 450;

const moverSlider = (direccion) => {
  slider.scrollBy({
    left: direccion * desplazamientoBoton,
    behavior: 'smooth'
  });
};

// Funciona tanto en PC como en telefonos
['mousedown', 'touchstart'].forEach(evento => {
  botonIzquierda.addEventListener(evento, () => moverSlider(-1));
  botonDerecha.addEventListener(evento, () => moverSlider(1));
});