<button id="guardar">Test Endpoint</button>
<script>
document.getElementById('guardar').addEventListener('click', function() {
    const noticia = {
        titulo: "Mi prueba",
        contenido: "Contenido de prueba"
    };

    const base = window.location.pathname.replace(/\/[^\/]*$/, ''); 
    const url = `${base}/index.php?pagina=test_api`;

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(noticia)
    })
    .then(res => res.json())
    .then(data => console.log(data))
    .catch(err => console.error(err));
});
</script>