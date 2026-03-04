<?php 
require_once 'config.php'; 

// --- DONNÉES TOP 5 APPLICATIONS ---
$sql_top = "SELECT a.nom, SUM(c.volume) as total 
            FROM consommation c 
            JOIN application a ON c.app_id = a.app_id 
            GROUP BY a.nom 
            ORDER BY total DESC 
            LIMIT 5";
$top_apps = $pdo->query($sql_top)->fetchAll(PDO::FETCH_ASSOC);

// --- DONNÉES ÉVOLUTION MENSUELLE ---
$sql_evol = "SELECT mois, SUM(volume) as total 
             FROM consommation 
             GROUP BY mois 
             ORDER BY mois ASC";
$evol_data = $pdo->query($sql_evol)->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$conso = [];
foreach($evol_data as $row) {
    $labels[] = date("M Y", strtotime($row['mois']));
    $conso[] = $row['total'];
}

// --- DONNÉES COMPARAISONS RESSOURCES ---
$sql_res = "SELECT r.nom, SUM(c.volume) as total, r.unite 
            FROM consommation c 
            JOIN ressource r ON c.res_id = r.res_id 
            GROUP BY r.nom";
$comparaison = $pdo->query($sql_res)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Tableau de bord - Campus IT</h1>
    
    <div class="tab">
      <button class="tablinks" onclick="openTab(event, 'Top-applications')">Top applications</button>
      <button class="tablinks" onclick="openTab(event, 'Evolution-mensuelle')">Evolution mensuelle</button>
      <button class="tablinks" onclick="openTab(event, 'Comparaisons-ressources')">Comparaisons ressources</button>
    </div>

    <div id="Top-applications" class="tabcontent">
      <h3>Top 5 des applications (consommation totale)</h3>
      <table border="1" style="width:100%; border-collapse: collapse; text-align: left;">
          <tr style="background-color: #eee;">
              <th>Application</th>
              <th>Consommation (Go/unités)</th>
          </tr>
          <?php foreach($top_apps as $app): ?>
          <tr>
              <td><?php echo $app['nom']; ?></td>
              <td><?php echo number_format($app['total'], 2); ?></td>
          </tr>
          <?php endforeach; ?>
      </table>
    </div>

    <div id="Evolution-mensuelle" class="tabcontent">
      <h3>Evolution mensuelle (total campus)</h3>
      <canvas id="evolutionChart" width="600" height="300"></canvas>
    </div>

    <div id="Comparaisons-ressources" class="tabcontent">
      <h3>Comparaison par type de ressource</h3>
      <ul>
          <?php foreach($comparaison as $c): ?>
              <li><strong><?= $c['nom'] ?> :</strong> <?= number_format($c['total'], 2) ?> <?= $c['unite'] ?></li>
          <?php endforeach; ?>
      </ul>
    </div>

    <script>
        // On injecte les données PHP dans le JavaScript pour Chart.js
        const labelsMois = <?php echo json_encode($labels); ?>;
        const dataConso = <?php echo json_encode($conso); ?>;
    </script>
    <script src="script.js"></script>
</body>
</html>