document.getElementById('menu-toggle').addEventListener('click', function() {
  const menu = document.getElementById('menu');
  const btn = document.getElementById('menu-toggle');
  
  // Alternar la clase 'active' para el menú y el botón
  menu.classList.toggle('active');
  btn.classList.toggle('active');
});
