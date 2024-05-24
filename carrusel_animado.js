//Agregar favoritos
/*let activeStates = {};

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
*/
// Carrusel 
let carrusel = document.getElementById("carrusel");
function desplazar(direction) {
  let scrollAmount = carrusel.clientWidth / 3.5;
  carrusel.scrollLeft += direction * scrollAmount;
}