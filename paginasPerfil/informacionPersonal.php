<div style="width: 100%;">
    <form id="formDatos" action="" method="post" enctype="multipart/form-data">
        <div class="foto-de-perfil">
            <div class="informacion-foto">
                <div class="usuario-avatar" id="fotoPerfil">
                    <img src="https://us.123rf.com/450wm/thesomeday123/thesomeday1231712/thesomeday123171200009/91087331-icono-de-perfil-de-avatar-predeterminado-para-hombre-marcador-de-posici%C3%B3n-de-foto-gris-vector-de.jpg';"
                        alt="Foto de perfil" class="avatar" id="avatar">
                </div>
                <span id="cargar" onclick="mostrarInput()">Cambiar Foto</span>
                <input type="file" id="cambiarFotoInput" name="cargarImagen" accept="image/*"
                    onchange="mostrarVistaPrevia(event)">
            </div>
            <div class="usuario-nombre" id="usuario-nombre">
                <h3 id="nombre-completo" style="font-size: 17px;  font-weight: bold; padding: 0;"></h3>
                <span id="fecha-registro" style="font-size: 12px; color: gray;"> </span>
            </div>
        </div>
        <div class="usuario-info">
            <fieldset>
                <legend>Usuario</legend>
                <div class="form-grupo">
                    <label class="label">
                        <span class="span">Nombre</span>
                        <input type="text" autocomplete="" id="nombre" name="nombre" value="" required>
                    </label>
                </div>
                <div class="form-grupo">
                    <label class="label">
                        <span class="span">Apellidos</span>
                        <input type="text" autocomplete="" id="apellidos" name="apellidos" value="" required>
                    </label>
                </div>

            </fieldset>
            <fieldset>
                <div class="form-grupo">
                    <label class="label-editado">
                        <span class="span">Correo Electronico</span>
                        <input type="email" autocomplete="" id="email" name="email" value="" required>
                    </label>
                </div>
                <div class="form-grupo">
                    <label class="label-editado">
                        <span class="span">Celular</span>
                        <input type="text" autocomplete="" id="celular" name="celular" value="">
                    </label>
                </div>
            </fieldset>
            <fieldset>
                <legend>Tu cuenta en GatitoDeveloper.com</legend>

                <div class="form-grupo">
                    <label class="label">
                        <span class="span">Numero De cliente</span>
                        <input type="text" autocomplete="" id="cliente" name="cliente" value="">
                    </label>
                </div>

                <div class="form-grupo">
                    <label class="label-editado">
                        <span class="span">Fecha de Nacimiento</span>
                        <select id="dia" name="dia">
                            <option value="" disabled selected>Día</option>
                            <?php for ($i = 1; $i <= 31; $i++): ?>
                                <option value="<?= $i ?>">
                                    <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <select id="mes" name="mes">
                            <option value="" disabled selected>Mes</option>
                            <?php
                            $meses = [
                                1 => 'Enero',
                                2 => 'Febrero',
                                3 => 'Marzo',
                                4 => 'Abril',
                                5 => 'Mayo',
                                6 => 'Junio',
                                7 => 'Julio',
                                8 => 'Agosto',
                                9 => 'Septiembre',
                                10 => 'Octubre',
                                11 => 'Noviembre',
                                12 => 'Diciembre'
                            ];
                            ?>
                            <?php foreach ($meses as $numero => $nombre): ?>
                                <option value="<?= $numero ?>">
                                    <?= $nombre ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select id="ano" name="ano">
                            <option value="" disabled selected>Año</option>
                            <?php for ($i = 1900; $i <= date('Y'); $i++): ?>
                                <option value="<?= $i ?>">
                                    <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </label>
                </div>
            </fieldset>
            <fieldset>

            </fieldset>
        </div>
        <button class="pagar" id="botonDatos">Guardar Cambios</button>
        <!--
            <input type="submit" name="guardarCambios" class="guardarCambios" value="Guardar cambios">
        -->
    </form>
    <div id="mostrarErrores">
    </div>
</div>
<script src="perfil.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        verDatos();
    })

    document.getElementById("botonDatos").addEventListener("click", function (event) {
        event.preventDefault();
        var formData = new FormData(document.getElementById("formDatos"));
        realizarSolicitudFetch(formData);
    });


    function realizarSolicitudFetch(formData) {
        fetch("../scriptsPHP/actualizarDatosUsuario.php", {
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
                    setTimeout(() => {
                        mostrarError.innerHTML = data.mensaje;
                        mostrarError.className = "mostrarExito";
                        console.log("Datos Guardados");
                        verDatos();
                    }, 2000);
                }
            })
            .catch((error) => {
                console.error("Error al enviar datos:", error);
            });
    }
    const mostrarError = document.getElementById("mostrarErrores");
    const formI = document.getElementById("formDatos");
    formI.addEventListener("click", function () {
        mostrarError.style.display = "none";
    });



function verDatos() {
  fetch("../scriptsPHP/datosPerfil.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `accion=verDatos`,
  })
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
        const nombre = data.nombre;
        const apellidos = data.apellidos;
        const email = data.email;
        const avatar = data.avatar;
        const celular = data.celular;
        //const fechaNac= data.fechaNacimiento;
        if (data.fechaNacimiento) {
          procesarFecha(data.fechaNacimiento);
        }
        //const sexo = data.sexo;
        const numeroCliente = data.numero_cliente;
        fechaRegistro(data.fecha_registro);

        const nombreCompleto = document.getElementById("nombre-completo");

        const fotoPerfil = document.getElementById("avatar");
        const inputNombre = document.getElementById("nombre");
        const inputApellido = document.getElementById("apellidos");
        const inputEmail = document.getElementById("email");
        //const inputSexo = document.getElementById("nombre");
        const inputCelular = document.getElementById("celular");
        const inputNumeroCliente = document.getElementById("cliente");

        nombreCompleto.textContent = `${nombre} ${apellidos}`;
        if (avatar.trim() !== '') {
          fotoPerfil.src = avatar;
        }else{
          fotoPerfil.src = 'https://us.123rf.com/450wm/thesomeday123/thesomeday1231712/thesomeday123171200009/91087331-icono-de-perfil-de-avatar-predeterminado-para-hombre-marcador-de-posici%C3%B3n-de-foto-gris-vector-de.jpg';
        }

        inputNombre.value = nombre;
        inputApellido.value = apellidos;
        inputEmail.value = email;
        inputCelular.value = celular;
        inputNumeroCliente.value = numeroCliente;
      } catch (error) {
        console.error("Error al analizar datos JSON:", error);
      }
    })
    .catch((error) => {
      console.error("Error al obtener Datos:", error);
    });
}

function procesarFecha(fechaN) {
  const fechaString = fechaN;
  const fecha = new Date(fechaString);

  const dia = fecha.getDate();
  const mes = fecha.getMonth() + 1;
  const anio = fecha.getFullYear();

  const selectDia = document.getElementById("dia");
  const selectMes = document.getElementById("mes");
  const selectAnio = document.getElementById("ano");

  for (var i = 0; i < selectDia.options.length; i++) {
    if (selectDia.options[i].value == dia) {
      selectDia.selectedIndex = i+1;
      break;
    }
  }
  for (var i = 0; i < selectMes.options.length; i++) {
    if (selectMes.options[i].value == mes) {
      selectMes.selectedIndex = i;
      break;
    }
  }
  for (var i = 0; i < selectAnio.options.length; i++) {
    if (selectAnio.options[i].value == anio) {
      selectAnio.selectedIndex = i;
      break;
    }
  }
}

function fechaRegistro(fechaR) {
  const Registro = document.getElementById("fecha-registro");
  const fecha = new Date(fechaR);

  const diaR = fecha.getDate();
  const mesR = fecha.getMonth();
  const anioR = fecha.getFullYear();

  const meses = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
  ];
  let mes = "";

  for (let i = 0; i < meses.length; i++) {
    if (mesR == i + 1) {
      mes = meses[i];
      break;
    }
  }
  Registro.innerText = `${diaR} de ${mes} de ${anioR}`;
}


</script>