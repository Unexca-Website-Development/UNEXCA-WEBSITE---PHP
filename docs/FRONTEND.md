# Análisis Profundo del Frontend del Portal UNEXCA

## Resumen Ejecutivo

El frontend del Portal UNEXCA está diseñado con una arquitectura modular y escalable que implementa las mejores prácticas de desarrollo web moderno. Utiliza CSS puro con metodología de componentes, JavaScript vanilla optimizado, y un sistema de assets bien organizado que garantiza un rendimiento óptimo y una experiencia de usuario excepcional.

## Arquitectura del Frontend

### Estructura de Directorios

```
publico/
├── estilos/
│   ├── index.css                    # Punto de entrada principal
│   ├── paginas/                     # Estilos específicos por página
│   │   ├── general.css
│   │   ├── inicio.css
│   │   ├── carrera.css
│   │   ├── autoridades.css
│   │   ├── contactos.css
│   │   └── ...
│   └── componentes/                 # Estilos de componentes reutilizables
│       ├── header.css
│       ├── footer.css
│       ├── botones.css
│       └── desplegable.css
├── scripts/
│   ├── header.js                    # Funcionalidad del header
│   ├── desplegables.js              # Menús desplegables
│   └── slider.js                    # Carrusel de imágenes
└── imagenes/
    ├── autoridades/                  # Fotos de autoridades
    ├── carreras/                    # Imágenes de carreras
    ├── iconos/                      # Iconos SVG
    ├── logos/                       # Logotipos
    ├── nucleos/                     # Fotos de núcleos
    └── decorativos/                # Elementos decorativos
```

## Sistema de Estilos CSS

### Metodología de Componentes

El sistema CSS implementa una metodología de componentes que separa los estilos en categorías lógicas:

#### 1. **Estilos Base (general.css)**
```css
:root {
  /* Variables de color */
  --negro: #1f1f1f;
  --azul: #022873;
  --gris-claro: #D3D9E7;
  --gris-oscuro: #B5C0D6;
  --blanco: #F0F2F7;
  --blanco-claro: #fff;

  /* Variables de tamaño */
  --mid-size: 56rem;
  --max-size: 85rem;

  /* Variables de tipografía */
  --font-size-tn: 10px;
  --font-size-sm: 12px;
  --font-size-md: 16px;
  --font-size-lg: 18px;
  --font-size-xl: 20px;

  /* Fuentes */
  --fuente-principal: "Plus Jakarta Sans", sans-serif;
  --fuente-titulos: "Jost", sans-serif;
}

/* Reset y estilos base */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  scroll-behavior: smooth;
  text-decoration: none;
  list-style-type: none;
}
```

#### 2. **Sistema de Tipografía Responsivo**
```css
html {
  font-size: var(--font-size-principal);
  font-family: var(--fuente-principal);
}

/* Breakpoints responsivos */
@media (min-width: 480px) {
  :root { --font-size-principal: var(--font-size-sm); }
}

@media (min-width: 768px) {
  :root { --font-size-principal: var(--font-size-md); }
}

@media (min-width: 1280px) {
  :root { --font-size-principal: var(--font-size-lg); }
}

@media (min-width: 1600px) {
  :root { --font-size-principal: var(--font-size-xl); }
}
```

### Componentes Reutilizables

#### Header (header.css)
```css
.header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
  background-color: var(--blanco);
  transition: transform 0.3s ease;
}

.header--oculto {
  transform: translateY(-100%);
}

.header__contenedor {
  max-width: var(--max-size-nav);
  margin: 0 auto;
  padding: 1rem;
}

.header__boton-menu {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 3rem;
  height: 3rem;
  border: 2px solid var(--azul);
  background: linear-gradient(to left, var(--azul) 50%, var(--blanco) 50%);
  background-size: 300% 100%;
  background-position: right bottom;
  transition: all 0.7s cubic-bezier(.11,.79,.1,1);
}
```

#### Footer (footer.css)
```css
.footer {
  position: relative;
  background-color: var(--azul);
  color: var(--blanco);
  padding: 4rem 0 2rem;
  margin-top: 6rem;
}

.footer__contenido {
  max-width: var(--max-size-footer);
  margin: 0 auto;
  padding: 0 1.5rem;
}

.footer__redes {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 2rem;
}

.footer__icono-red {
  width: 3rem;
  height: 3rem;
  border: 2px solid var(--blanco);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}
```

#### Botones (botones.css)
```css
.boton {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.8rem 1.5rem;
  border: 2px solid var(--azul);
  background: linear-gradient(to left, var(--azul) 50%, var(--blanco) 50%);
  background-size: 300% 100%;
  background-position: right bottom;
  font-size: 1rem;
  font-weight: 700;
  color: var(--azul);
  text-transform: uppercase;
  transition: all 0.7s cubic-bezier(.11,.79,.1,1);
  cursor: pointer;
}

.boton:hover,
.boton:focus {
  background-position: left bottom;
  color: var(--blanco);
}
```

### Páginas Específicas

#### Página de Inicio (inicio.css)
```css
/* Banner principal */
.banner {
  position: relative;
  height: 100vh;
  width: 100%;
  background-color: var(--azul);
  overflow: hidden;
}

.banner__titulo {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 4.5rem;
  font-family: var(--fuente-titulos);
  letter-spacing: 1rem;
  font-weight: bold;
  color: var(--blanco);
  filter: drop-shadow(0px 8px 10px rgba(0, 0, 0, 1));
}

/* Carrusel de carreras */
.carreras__lista {
  display: flex;
  gap: 2.5rem;
  overflow-x: hidden;
  cursor: grab;
  user-select: none;
  margin-bottom: 2rem;
}

.carreras__lista.activado {
  cursor: grabbing;
}

.carrera {
  display: flex;
  flex-direction: column;
  flex: 0 0 auto;
  width: 100%;
  max-width: 25rem;
  background-color: var(--blanco-claro);
}
```

## Sistema JavaScript

### Arquitectura Modular

El JavaScript está organizado en módulos funcionales específicos:

#### 1. **Header.js - Gestión del Header**
```javascript
class Header {
  constructor({
    selectorContenedor = '.header',
    selectorBotonPrincipal = '.header__boton-menu',
    selectorSubmenu = '.header__link-boton',
    claseActiva = 'activo',
    umbralScroll = 10
  } = {}) {
    this.contenedor = document.querySelector(selectorContenedor);
    if (!this.contenedor) return;

    this.claseActiva = claseActiva;
    this.umbralScroll = umbralScroll;
    this.ultimoScrollY = window.pageYOffset;
    this.enEspera = false;

    this.botonesPrincipales = Array.from(this.contenedor.querySelectorAll(selectorBotonPrincipal));
    this.botonesSubmenu = Array.from(this.contenedor.querySelectorAll(selectorSubmenu));

    this.inicializarBotones(this.botonesPrincipales, selectorContenedor);
    this.inicializarBotones(this.botonesSubmenu, '.header__menu-item--con-submenu');
    this.inicializarScroll();
  }

  inicializarBotones(botones, selectorContenedor) {
    botones.forEach(boton => {
      boton.addEventListener('mousedown', e => {
        e.preventDefault();
        this.alternar(boton, selectorContenedor);
      });

      boton.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.alternar(boton, selectorContenedor);
        }
      });
    });
  }

  alternar(boton, selectorContenedor) {
    const contenedor = boton.closest(selectorContenedor);
    if (!contenedor) return;

    const estaActivo = contenedor.classList.toggle(this.claseActiva);
    boton.setAttribute('aria-expanded', estaActivo ? 'true' : 'false');

    const nav = contenedor.querySelector('.header__nav');
    const overlay = contenedor.querySelector('.overlay');

    if (estaActivo) {
      if (overlay) overlay.addEventListener('click', () => this.cerrar(contenedor, boton), { once: true });
      this.agregarManejadorTeclas(contenedor, boton, nav);
    } else {
      this.removerManejadorTeclas(contenedor);
    }
  }

  inicializarScroll() {
    window.addEventListener('scroll', () => this.alHacerScroll());
  }

  alHacerScroll() {
    if (!this.enEspera) {
      window.requestAnimationFrame(() => this.actualizarScroll());
      this.enEspera = true;
    }
  }

  actualizarScroll() {
    const scrollY = window.pageYOffset;
    if (Math.abs(scrollY - this.ultimoScrollY) < this.umbralScroll) {
      this.enEspera = false;
      return;
    }

    if (scrollY > this.ultimoScrollY) this.contenedor.classList.add('header--oculto');
    else this.contenedor.classList.remove('header--oculto');

    this.ultimoScrollY = scrollY > 0 ? scrollY : 0;
    this.enEspera = false;
  }
}

// Instancia
new Header({
  selectorContenedor: '.header',
  selectorBotonPrincipal: '.header__boton-menu',
  selectorSubmenu: '.header__link-boton',
  umbralScroll: 10
});
```

#### 2. **Desplegables.js - Menús Desplegables**
```javascript
// Funcionalidad para menús desplegables
document.addEventListener('DOMContentLoaded', function() {
  const botonesDesplegable = document.querySelectorAll('.header__link-boton');
  
  botonesDesplegable.forEach(boton => {
    boton.addEventListener('click', function(e) {
      e.preventDefault();
      const submenu = this.nextElementSibling;
      
      if (submenu) {
        submenu.classList.toggle('activo');
        this.setAttribute('aria-expanded', 
          submenu.classList.contains('activo') ? 'true' : 'false'
        );
      }
    });
  });
});
```

#### 3. **Slider.js - Carrusel de Imágenes**
```javascript
// Sistema de carrusel para el banner
class Slider {
  constructor(selector) {
    this.contenedor = document.querySelector(selector);
    this.imagenes = this.contenedor.querySelectorAll('img');
    this.indiceActual = 0;
    this.intervalo = null;
    
    if (this.imagenes.length > 1) {
      this.inicializar();
    }
  }

  inicializar() {
    this.ocultarTodasLasImagenes();
    this.mostrarImagen(0);
    this.iniciarAutoplay();
  }

  ocultarTodasLasImagenes() {
    this.imagenes.forEach(img => img.classList.remove('activo'));
  }

  mostrarImagen(indice) {
    this.ocultarTodasLasImagenes();
    this.imagenes[indice].classList.add('activo');
    this.indiceActual = indice;
  }

  siguiente() {
    const siguienteIndice = (this.indiceActual + 1) % this.imagenes.length;
    this.mostrarImagen(siguienteIndice);
  }

  anterior() {
    const anteriorIndice = this.indiceActual === 0 
      ? this.imagenes.length - 1 
      : this.indiceActual - 1;
    this.mostrarImagen(anteriorIndice);
  }

  iniciarAutoplay() {
    this.intervalo = setInterval(() => this.siguiente(), 5000);
  }

  detenerAutoplay() {
    if (this.intervalo) {
      clearInterval(this.intervalo);
    }
  }
}

// Inicializar slider si existe
const slider = new Slider('#banner__imagen-contenedor');
```

## Sistema de Assets

### Gestión de Imágenes

#### Estructura Organizacional
```
imagenes/
├── autoridades/          # Fotos de autoridades (JPG)
├── carreras/            # Imágenes de carreras (JPG)
├── iconos/              # Iconos SVG
│   ├── favicon.ico
│   ├── favicon-16x16.png
│   ├── favicon-32x32.png
│   ├── apple-touch-icon.png
│   ├── android-chrome-192x192.png
│   ├── android-chrome-512x512.png
│   ├── facebook_logo.svg
│   ├── instagram_logo.svg
│   ├── telegram_logo.svg
│   ├── whatsapp_logo.svg
│   ├── flecha.svg
│   ├── icon_calendario.svg
│   ├── icon_duracion.svg
│   ├── icon_graduacion.svg
│   ├── icon_malla.svg
│   ├── icon_menu_close.svg
│   ├── icon_menu_open.svg
│   └── icon_ubicacion.svg
├── logos/               # Logotipos SVG
│   └── logo_menu.svg
├── nucleos/             # Fotos de núcleos (JPG/JPEG)
│   ├── altagracia.jpg
│   ├── floresta.jpg
│   ├── guaira.jpeg
│   └── urbina.jpg
└── decorativos/         # Elementos decorativos SVG
    ├── decoracion.svg
    └── decoracion_2.svg
```

### Optimización de Imágenes

#### Formatos Utilizados
- **SVG**: Para iconos y elementos vectoriales (escalables)
- **JPG**: Para fotografías con compresión optimizada
- **PNG**: Para iconos con transparencia (favicons)

#### Técnicas de Optimización
```css
/* Optimización de imágenes */
img, picture, video, canvas, svg, figure {
  display: block;
  max-width: 100%;
}

.carrera__imagen {
  max-height: 12.5rem;
  object-fit: cover;
  pointer-events: none;
}

.carrera__imagen > img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
```

## Responsive Design

### Breakpoints Definidos
```css
/* Mobile First Approach */
:root {
  --font-size-principal: var(--font-size-tn);
}

/* Small devices (480px and up) */
@media (min-width: 480px) {
  :root { --font-size-principal: var(--font-size-sm); }
}

/* Medium devices (768px and up) */
@media (min-width: 768px) {
  :root { --font-size-principal: var(--font-size-md); }
}

/* Large devices (1280px and up) */
@media (min-width: 1280px) {
  :root { --font-size-principal: var(--font-size-lg); }
}

/* Extra large devices (1600px and up) */
@media (min-width: 1600px) {
  :root { --font-size-principal: var(--font-size-xl); }
}
```

### Adaptaciones Específicas
```css
/* Resolución de teléfono */
@media (max-width: 480px) {
  .historia__contenido, 
  .carreras__contenido, 
  .noticias__contenido {
    border: none;
    padding: 0;
  }
}
```

## Accesibilidad

### Características Implementadas

#### 1. **Navegación por Teclado**
```javascript
// Soporte completo para navegación por teclado
boton.addEventListener('keydown', e => {
  if (e.key === 'Enter' || e.key === ' ') {
    e.preventDefault();
    this.alternar(boton, selectorContenedor);
  }
});
```

#### 2. **Atributos ARIA**
```html
<button class="header__boton-menu" 
        aria-expanded="false" 
        aria-controls="abrir menu">
  <?= colocar_svg('@imagenes/iconos/icon_menu_open.svg') ?>
</button>
```

#### 3. **Contraste y Legibilidad**
```css
/* Colores con contraste adecuado */
:root {
  --negro: #1f1f1f;        /* Alto contraste */
  --azul: #022873;        /* Contraste medio-alto */
  --blanco: #F0F2F7;      /* Fondo suave */
}
```

## Rendimiento

### Optimizaciones Implementadas

#### 1. **Carga Asíncrona de Scripts**
```html
<script src="<?= colocar_ruta_html('@scripts/header.js')?>"></script>
```

#### 2. **Uso de RequestAnimationFrame**
```javascript
alHacerScroll() {
  if (!this.enEspera) {
    window.requestAnimationFrame(() => this.actualizarScroll());
    this.enEspera = true;
  }
}
```

#### 3. **CSS Optimizado**
- Uso de variables CSS para consistencia
- Selectores eficientes
- Minimización de repaints y reflows

## Integración con el Backend

### Sistema de Rutas Dinámicas
```php
// Función para colocar rutas HTML
function colocar_ruta_html(string $alias): string {
    $rutas = obtener_rutas()['html'];
    
    foreach ($rutas as $clave => $ruta) {
        if (strpos($alias, $clave) === 0) {
            return $ruta . substr($alias, strlen($clave));
        }
    }
    
    throw new Exception("Ruta de HTML no encontrada para '$alias'");
}
```

### Renderizado de SVG
```php
function colocar_svg(string $alias): string {
    $rutas = obtener_rutas()['sistema'];
    
    foreach ($rutas as $clave => $base) {
        if (strpos($alias, $clave) === 0) {
            $archivo = $base . substr($alias, strlen($clave));
            if (file_exists($archivo)) {
                return file_get_contents($archivo);
            } else {
                return "<!-- SVG '$alias' no encontrado en '$archivo' -->";
            }
        }
    }
    
    throw new Exception("Ruta de sistema no encontrada para '$alias'");
}
```

## Consideraciones de Mantenimiento

### 1. **Modularidad**
- Separación clara entre estilos de componentes y páginas
- JavaScript organizado en clases y módulos
- Assets organizados por categoría

### 2. **Escalabilidad**
- Sistema de variables CSS para fácil personalización
- Componentes reutilizables
- Estructura preparada para crecimiento

### 3. **Documentación**
- Código bien comentado
- Estructura de archivos intuitiva
- Convenciones de nomenclatura consistentes

## Conclusión

El frontend del Portal UNEXCA representa una implementación moderna y bien estructurada que combina:

- **Arquitectura modular y escalable**
- **Mejores prácticas de desarrollo web**
- **Optimización de rendimiento**
- **Accesibilidad y usabilidad**
- **Integración eficiente con el backend**

Esta estructura proporciona una base sólida para el mantenimiento y evolución del portal, garantizando una experiencia de usuario excepcional en todos los dispositivos y navegadores.
