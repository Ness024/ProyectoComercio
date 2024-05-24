function verDireccion() {
    fetch("scriptsPHP/consultarDomicilio.php")
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
                if (!data.hasOwnProperty('usuario')) {
                    console.warn("La respuesta no tiene la propiedad 'usuario'.");
                    return;
                }
                const usuario = data.usuario;

                document.getElementById('pnombre').value = usuario.nombre;
                document.getElementById('papellido').value = usuario.apellidos;
                document.getElementById('telefono').value = usuario.celular;
                document.getElementById('pcalle').value = usuario.direccion;
                document.getElementById('pcolonia').value = usuario.colonia;
                document.getElementById('pciudad').value = usuario.ciudad;
                document.getElementById('pcp').value = usuario.codigo_postal;
                document.getElementById('nExterior').value = usuario.nro_exterior;
                document.getElementById('nInterior').value = usuario.nro_interior;
                document.getElementById('referencias').value = usuario.descripcion;
            } catch (error) {
                console.error("Error al analizar datos JSON:", error);
            }
        })
        .catch((error) => {
            console.error("Error al obtener Datos:", error);
        });
}

document.getElementById("botonDomicilio").addEventListener("click", function (event) {
    event.preventDefault();
    var formData = new FormData(document.getElementById("formDomicilio"));
    registrarDireccion(formData);
});

function registrarDireccion(formData) {
    fetch("scriptsPHP/updateDomicilio.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            const mostrarError = document.getElementById("mostrarErrores");
            mostrarError.style.display = "flex";
            if (data.error) {
                mostrarError.innerHTML = data.mensaje;
                mostrarError.className = "mostrarErrores";
                console.log("No se pudieron Guardar los datos");
            } else {
                mostrarError.innerHTML = data.mensaje;
                mostrarError.className = "mostrarExito";
                console.log("Datos Guardados");
                    verDireccion();
            }
            setTimeout(() => {
                mostrarError.style.display = "none";
            }, 2000);
        })
        .catch((error) => {
            console.error("Error al enviar datos:", error);
        });
}