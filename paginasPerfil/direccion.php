
    <form action="" method="post" class="form-pago" id="formDireccion">
        <h3>Dirección de entrega</h3>
        <fieldset>
            <label for="s" class="reuso">
                <input type="checkbox" name="s" id="s">Usar dirección de envio</label>
            <label for="calle">Calle</label>
            <input type="text" name="calle" id="calle"  placeholder="Ingrese su calle">

            <label for="colonia">Colonia</label>
            <input type="text" name="colonia" id="colonia"  placeholder="Ingrese su colonia">

            <label for="ciudad">Ciudad</label>
            <input type="text" name="ciudad" id="ciudad"  placeholder="Ingrese su ciudad">
            <label for="numE" class="mas-info-direccion">
                <input type="text" name="cp" id="cp" pattern="[0-9]{5}"  placeholder="Codigo Postal">
                <input type="text" name="numE" id="numE"  placeholder="Número exterior">
                <input type="text" name="numI" id="numI" placeholder="Número interior">
            </label>
        </fieldset>
        <button class="pagar" id="botonDireccion">Guardar Cambios</button>
    </form>
    <div id="mostrarErrores">
    </div>
<link rel="stylesheet" href="estilosPasarela.css">
<style>
    /*nuevo edit*/
    .form-pago {
        width: 80%;
        max-width: 950px;
        padding: 0% 5%;
    }
</style>

<script>
    

document.getElementById("botonDireccion").addEventListener("click", function (event) {
  event.preventDefault();
  var formData = new FormData(document.getElementById("formDireccion"));
  registrarDomicilio(formData);
});

function registrarDomicilio(formData) {
fetch("scriptsPHP/registrarDomicilio.php", {
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

    }
    setTimeout(() => {
                mostrarError.style.display = "none";
            }, 2000);
  })
  .catch((error) => {
    console.error("Error al enviar datos:", error);
  });
}
</script>