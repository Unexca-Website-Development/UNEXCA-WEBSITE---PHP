
<button id="guardar">Test Endpoint</button>
<script>
    document.getElementById('guardar').addEventListener('click', function() {
        const titulo = "Mi prueba";
        const contenido = "Contenido de prueba";
        const base = window.location.pathname.replace(/\/[^\/]*$/, ''); 
        
        const url = `${base}/index.php?pagina=test_api&titulo=${encodeURIComponent(titulo)}&contenido=${encodeURIComponent(contenido)}`;

        fetch(url, { method: 'POST' })
            .then(res => res.json())
            .then(data => console.log(data))
            .catch(err => console.error(err));
    });
</script>
