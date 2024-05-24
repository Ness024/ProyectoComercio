function verDatos() {
    fetch("", {
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
  