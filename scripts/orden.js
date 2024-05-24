function verOrden() {
    fetch("scriptsPHP/verOrden2.php")
        .then((response) => {
            if (!response.ok) {
                throw new Error(`Error en la solicitud: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            try {
                if (Object.keys(data).length === 0) {
                    console.warn("La respuesta está vacía.");
                    return;
                }
                if (!data.hasOwnProperty("orden")) {
                    console.warn("La respuesta no tiene la propiedad 'orden'.");
                    return;
                }
                const verOrden = data.orden;

                document.getElementById("nombre-cliente").innerHTML = `${verOrden.nombre} ${verOrden.apellidos}`;
                document.getElementById("direccion").innerHTML = `${verOrden.direccion}, ${verOrden.colonia}, ${verOrden.ciudad} ,${verOrden.codigo_postal}`;
                document.getElementById("titular").innerHTML = verOrden.apellido_titular;
                document.getElementById("tipo-targeta").innerHTML = 'Tarjeta de Crédito';
                document.getElementById("numero-targeta").innerHTML = `**** **** **** ${verOrden.ultimos_digitos}`;
                document.getElementById("vencimiento").innerHTML = verOrden.fecha_expiracion;
                document.getElementById("vencimiento").innerHTML = verOrden.fecha_expiracion;
                document.getElementById("cantidad-productos").innerHTML = verOrden.cantidad_total;
                document.getElementById("total-pagar").innerHTML = `$ ${verOrden.total_pagar}`;
            } catch (error) {
                console.error("Error al analizar datos JSON:", error);
            }
        })
        .catch((error) => {
            console.error("Error al obtener Datos:", error);
        });
}

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('limpiar').addEventListener('click', function(e) {
            e.preventDefault();

            fetch('../scriptsPHP/procesarPago.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error en la solicitud: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    alert('Error en el procesamiento del pago. Por favor, inténtalo de nuevo.');
                } else {
                    window.location.href = 'exito.php';
                }
            })
            .catch(error => {
                console.error('Error en la solicitud fetch:', error);
                alert('Error en el procesamiento del pago. Por favor, inténtalo de nuevo.');
            });
        });
    });
