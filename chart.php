<?php
// include "functions/functions.php";
// include "functions/db.php";
include "./components/header.inc.php";

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var data = <?php echo get_data_for_chart(); ?>;

    // Priprema podataka za pie chart
    var pieLabels = data.map(function (item) {
      return item.category;
    });

    var pieValues = data.map(function (item) {
      return parseInt(item.num);
    });

    // Konfiguracija i crtanje PIE charta
    var pieCtx = document.getElementById("pie-chart").getContext("2d");
    var pieChart = new Chart(pieCtx, {
      type: "pie",
      data: {
        labels: pieLabels,
        datasets: [
          {
            data: pieValues,
            backgroundColor: [
              "#ff6384",
              "#36a2eb",
              "#ffce56",
              "#8bc34a",
              "#ffc107",
              "#9c27b0"
            ]
          }
        ]
      },
      options: {
        responsive: true
      }
    });

    // Priprema podataka za bar chart
    var barLabels = data.map(function (item) {
      return item.category;
    });

    var barValues = data.map(function (item) {
      return parseInt(item.num);
    });

    // Konfiguracija i crtanje BAR charta
    var barCtx = document.getElementById("bar-chart").getContext("2d");
    var barChart = new Chart(barCtx, {
      type: "bar",
      data: {
        labels: barLabels,
        datasets: [
          {
            label: "Zastupljenost",
            data: barValues,
            backgroundColor: [
              "#ff6384",
              "#36a2eb",
              "#ffce56",
              "#8bc34a",
              "#ffc107",
              "#9c27b0"
            ]
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  });
</script>



<section class="charts" style="">
  <div class="container">
    <div class="py-5 ">
      <h2>Grafički prikaz</h2>
      <p>Statistika na osnovu podataka sa celokupne mreže</p>
    </div>
    <div class="py-5 ">
      <h3>Zastupljenost objava po kategorijama</h2>
        <p>U prilogu se nalazi grafički prikaz <i>(pie chart, bar chart)</i> podataka o zastupljenosti
          objava po kategorijama</p>
    </div>

    <div class="row align-items-center justify-content-space-between">
      <div class="chart-holder col-12 col-lg-5 chart-01">
        <canvas id="pie-chart"></canvas>
      </div>

      <div class="chart-holder col-12 col-lg-5 chart-02 d-none">
        <canvas id="bar-chart"></canvas>
      </div>

      <div class="mt-4">
        <button id="toggle-button" class="primary-button mt-3" style="max-width:  240px;">
          Promeni Grafik
        </button>
      </div>

    </div>

  </div>

 

</section>


<?php

include "./components/footer.inc.php";

?>