
document.addEventListener('DOMContentLoaded', function () {
    verPago();
});
function verPago() {
    fetch("scriptsPHP/consultarTargeta.php")
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
                if (!data.hasOwnProperty("tarjeta")) {
                    console.warn("La respuesta no tiene la propiedad 'tarjeta'.");
                    return;
                }
                const pTargeta = data.tarjeta;

                document.getElementById("nombre").value = pTargeta.primer_nombre;
                document.getElementById("segundo-nombre").value = pTargeta.segundo_nombre;
                document.getElementById("titular").value = pTargeta.apellido_titular;
                document.getElementById("numerodetarjeta").value = pTargeta.numero_tarjeta;
                document.getElementById("fecha").value = pTargeta.fecha_expiracion;
                document.getElementById("cvv").value = pTargeta.cvv;
            } catch (error) {
                console.error("Error al analizar datos JSON:", error);
            }
        })
        .catch((error) => {
            console.error("Error al obtener Datos:", error);
        });
}

document.getElementById("botonPago").addEventListener("click", function (event) {
        event.preventDefault();
        var formData = new FormData(document.getElementById("formPago"));
        registrarPago(formData);
    });

function registrarPago(formData) {
    fetch("scriptsPHP/registrarFormaDePago.php", {
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
                console.log(data.mensaje);
            } else {
                mostrarError.innerHTML = data.mensaje;
                mostrarError.className = "mostrarExito";
                console.log("Datos Guardados");

                setTimeout(() => {
                    verPago();
                }, 2000);
            }
            setTimeout(() => {
                mostrarError.style.display = "none";
            }, 2000);
        })
        .catch((error) => {
            console.error("Error al enviar datos:", error);
        });
}
