function verDatos() {
  fetch("scriptsPHP/datosPerfil.php", {
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

function mostrarInput() {
  document.getElementById("cambiarFotoInput").click();
}

function mostrarVistaPrevia(event) {
  const input = event.target;
  const fotoPerfil = document.getElementById("fotoPerfil");
  //const previewFoto = document.getElementById('previewFoto');
  //const imagenPreview = document.getElementById('imagenPreview');

  if (input.files && input.files[0]) {
    const reader = new FileReader();

    reader.onload = function (e) {
      fotoPerfil.innerHTML =
        '<img src="' + e.target.result + '" alt="Nueva foto de perfil" class="avatar">';

      //previewFoto.style.display = 'block';
      //imagenPreview.src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

