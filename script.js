
let carrito = [];
let total = 0;

let cont = document.getElementById('carritoCont');
let contador = Number(cont.innerText);

function agregarAlCarrito(productoId) {

    fetch("scriptsPHP/agregarAlCarrito.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `producto_id=${productoId}`,
    })
        .then(() => {
            verCantidad();
            console.log("Producto agregado al carrito");
            //verCarrito();
        })
        .catch((error) =>
            console.error("Error al agregar producto al carrito:", error)
        );
}

function verCantidad() {
    fetch('scriptsPHP/verCantidad.php')
        .then((response) => response.json())
        .then((datos) => {

            if (!datos.hasOwnProperty("cantidad")) {
                console.warn("La respuesta no tiene la propiedad 'cantidad'.");
                return;
            }
            const verCantidad = datos.cantidad;

            const estaVacio = !verCantidad.cantidad_total || verCantidad.cantidad_total.trim() === '';

            if (estaVacio) {
                cont.style.display = 'none';
            } else {
                cont.style.display = 'flex';
                cont.innerText = verCantidad.cantidad_total;
            }
        })
        .catch((error) =>
            console.error("Error al obtener cantidad", error)
        );
}

function irAVerCarrito() {
    window.location.href = "carritoCompras.php";
}

function verCarrito() {

    fetch(`scriptsPHP/vistaCarrito.php`)
        .then((response) => response.json())
        .then((carrito) => {
            const listaCarrito = document.getElementById("productoCarrito");
            const totalCarrito = document.getElementById("total-carrito");
            const ulSubtotal = document.getElementById("subtotal");
            const limpiar = document.getElementById("limpiar");

            listaCarrito.innerHTML = "";
            ulSubtotal.innerHTML = "";
            total = 0;


            if (Array.isArray(carrito) && carrito.length > 0) {
                carrito.forEach((item) => {
                    const li = document.createElement("li");
                    li.className = "productoCarrito";
                    // li.textContent = `${item.nombre} - Cantidad: ${item.cantidad} - $${parseFloat(item.total).toFixed(2)}`;
                    li.innerHTML = `<a href="" class="imglink"><img src="${item.imagen}" alt=""></a>
                <div style="height: 100%; padding-top: 5px;">
                    <a href="" class="carritoComprasProducto">${item.nombre} </a>
                    <p class="lllll">${item.descripcion}</p>
                    <p class="precio"> <span style="color: gray;">Precio: </span>$${parseFloat(item.precio).toFixed(2)}</p>
                    <p class="llllll">Cantidad:</p>    
                    <span class="masmenosproductos">
                        <button id="bntMenos1" onclick="modificarCantidad(${item.id}, -1)" class="limp">-</button>
                        <p class="cantidadProducto" id="cantidad"> ${item.cantidad}</p>
                        <button id="btnMas1" onclick="modificarCantidad(${item.id}, 1)" class="limp">+</button>
                    </span>
                    <button onclick="eliminarProductoDeCarrito(${item.id})" class="limp">Eliminar</button>
                </div>`;

                    const subtotal = document.createElement("li");
                    subtotal.innerHTML = `<p> ${item.nombre} </p> <p id="p1">$ ${item.total} </p>`;

                    listaCarrito.appendChild(li);
                    ulSubtotal.appendChild(subtotal);
                    total += parseFloat(item.total);
                });

                totalCarrito.textContent = `$ ${total.toFixed(2)}`;
                if(limpiar.style.display === "none"){
                limpiar.style.display = "block";
                }
            } else {
                const carritoVacio = document.createElement("li");
                carritoVacio.textContent = 'No hay productos agregados';
                listaCarrito.appendChild(carritoVacio);

                if(limpiar.style.display === "block"){
                    limpiar.style.display = "none"; 
                    carritoVacio.style.textAlign = "center";
                    carritoVacio.style.font = "19px System-Ui";
                }

            }

        })
        .catch((error) =>
            console.error("Error al obtener contenido del carrito:", error)
        );
}


function modificarCantidad(productoId, cantidad) {

    fetch(`scriptsPHP/modificarCantidad.php?producto_id=${productoId}&cantidad=${cantidad}`, {
        method: "POST",
    })
        .then(() => {
            console.log("Cantidad cambiado");
            verCarrito();
            verCantidad();

        })
        .catch((error) => console.error("Error al cambiar la cantidad:", error));
}

function limpiarCarrito() {

    fetch('scriptsPHP/limpiarCarrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `accion=limpiarCarrito`,
    })

        .then(() => {
            console.log("Carrito limpiado");
            verCarrito();
            verCantidad();
        })
        .catch((error) => console.error("Error al limpiar el carrito:", error));
}

function eliminarProductoDeCarrito(productoId) {

    fetch('scriptsPHP/limpiarCarrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `producto_id=${productoId}&accion=eliminarProducto`,
    })
        .then(response => response.json())
        .then(data => {
            const mostrarError = document.getElementById("mostrarErrores");
            mostrarError.style.display = "flex";
            if (data.error) {
                mostrarError.innerHTML = data.mensaje;
                mostrarError.className = 'mostrarErrores';
                console.log("Error al eliminar");
            } else {
                mostrarError.innerHTML = data.mensaje;
                mostrarError.className = 'mostrarExito';
                console.log("Producto eliminado");
                verCarrito();
                verCantidad();
            }
            setTimeout(() => {
                mostrarError.style.display = "none";
            }, 2000);
        })
        .catch(error => console.error('Error al realizar la solicitud:', error));

}



//Agregar favoritos
let activeStates = {};

function toggleActive(productId) {
    activeStates[productId] = !activeStates[productId];
    const botonFavoritos = document.querySelector(`[data-product-id='${productId}'] .botonFavoritos`);
    console.log(botonFavoritos);
    if (activeStates[productId]) {
        botonFavoritos.classList.add("active");
    } else {
        botonFavoritos.classList.remove("active");
    }
}

//Eliminar favoritos de la seccion Favoritos 
function toggleOff(productId) {
    activeStates[productId] = !activeStates[productId];
    const botonSecFavoritos = document.querySelector(`[data-product-id='${productId}'] .botonFavoritos`);
    console.log(botonSecFavoritos);
    if (activeStates[productId]) {
        botonSecFavoritos.classList.remove("active");
    } else {
        botonSecFavoritos.classList.add("active");
    }
}