
<form action="" method="post" class="form-pago" id="formPago">
    <h3>Información de la tarjeta de crédito/débito</h3>
    <fieldset>
        <label for="nombre">Nombre</label>
        <label for="nombre" class="nombres">
            <input type="text" placeholder="Primer nombre" required autocomplete="cc-given-name" name="nombre"
                id="nombre" />
            <input type="text" placeholder="Segundo nombre" autocomplete="cc-given-name" name="segundo-nombre"
                id="segundo-nombre" />
        </label>
        <label for="titular">Apellido</label>
        <input type="text" placeholder="Apellido titular" required autocomplete="cc-family-name" name="titular"
            id="titular" />
        <label for="numerodetarjeta">Número de tarjeta de crédito/débito.</label>
        <input type="text" pattern="[0-9]*" maxlength="16" placeholder="Número de tarjeta" required
            autocomplete="cc-number" name="numerodetarjeta" id="numerodetarjeta" />
        <label for="fecha" class="datostarjetas">
            <input type="text" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" placeholder="Fecha (MM/YY)" required
                autocomplete="cc-exp" name="fecha" id="fecha" />
            <input type="text" pattern="[0-9]{3,4}" maxlength="4" placeholder="CVV" required autocomplete="cc-csc"
                name="cvv" id="cvv" />
        </label>
    </fieldset>
    
    <button class="pagar" id="botonPago">Guardar Cambios</button>
</form>
<div id="mostrarErrores">
</div>

<link rel="stylesheet" href="estilosPasarela.css">
<style>
    .mostrarErrores,
    .mostrarExito {
        width: 300px;
        height: 50px;
        border-radius: 5px;
        font-size: 13px;
        font-family: ui-monospace;
        font-weight: 500;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mostrarErrores {
        border: 1px solid #ff000047;
        background-color: rgb(255 37 37 / 22%);
        color: #bb4040;
    }

    .mostrarExito {
        border: 1px solid #00ff0047;
        background-color: rgb(37 255 155 / 22%);
        color: #40bb42;
    }

    /*nuevo edit*/
    main{
        display: flex;
        flex-direction: row;
        padding: 0 20px;
    }

.form-pago {
    width: 80%;
    max-width: 950px;
    padding: 0% 5%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

</style>
<script src="scripts/verTargeta.js">

</script>