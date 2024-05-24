document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const searchTerm = document.getElementById('searchInput').value;
    buscarDatos(searchTerm);
});

function buscarDatos(searchTerm) {
    fetch('scriptsPHP/busqueda.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'searchTerm=' + encodeURIComponent(searchTerm),
    })
    .then(response => response.json())
    .then(data => {
        window.location.href = 'verResultados.php?' + new URLSearchParams({ resultados: JSON.stringify(data) });
    })
    .catch(error => console.error('Error en la búsqueda:', error));
}