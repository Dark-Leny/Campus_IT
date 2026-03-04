// fonction pour les boutons des rubriques
function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Initialisation du graphique avec les données venant de l'index.php
window.addEventListener("DOMContentLoaded", function () {
  const ctx = document.getElementById("evolutionChart").getContext("2d");

  new Chart(ctx, {
    type: "line",
    data: {
      labels: labelsMois, // Variable définie dans index.php
      datasets: [{
        label: "Consommation totale",
        data: dataConso, // Variable définie dans index.php
        borderColor: "blue",
        tension: 0.3,
        fill: true,
        backgroundColor: "rgba(0, 0, 255, 0.1)"
      }]
    },
    options: {
      responsive: true,
      scales: { y: { beginAtZero: true } }
    }
  });
});