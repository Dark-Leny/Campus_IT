<!DOCTYPE html>
<html>
<head>
    <title>Evolution mensuelle (total campus)</title>
    <style type="text/css">
        body {
            width: 550px;
        }
        #chart-container {
            width: 100%;
            height: auto;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <?php
    // requete pdo vers table des traversées de Océane pour récupérer le nb de traversées par jour en septembre 2022
    $pdo = new PDO('mysql:host=localhost;dbname=oceane;charset=utf8', 'root', '');
    $sql = "SELECT COUNT(*) AS nb, DAY(date) as day FROM traversee WHERE YEAR(date) = 2022 AND MONTH(date) = 9 GROUP BY DAY(date); ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $traversees = $stmt->fetchAll(PDO::FETCH_ASSOC);
 ?>


    <h1>Graphique démo dynamique</h1>
    <!-- on crée un canvas pour y afficher le graphique -->
    <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div>

    <script>
        // on lance la fonction showGraph au chargement de la page
        document.addEventListener('DOMContentLoaded', function () {
            // on récupère les données php en JSON
            var traverseesData = <?php echo json_encode($traversees); ?>;
            console.log(traverseesData);
            var jours = [];
            var nombres = [];
            // on parcourt les données pour les mettre dans des tableaux distincts jours et nombres
            for (var i in traverseesData) {
                jours.push(traverseesData[i].day);
                nombres.push(traverseesData[i].nb);
            }
            console.log(jours);
            console.log(nombres);

            // on fabrique à partir des tableaux jours et nombres la structure de données attendue par Chart.js pour un graphique en lignes
            var chartdata = {
                labels: jours,
                datasets: [{
                    label: 'nb de traversées par jour en septembre 2022',
                    borderColor: 'rgb(75, 192, 192)',
                    data: nombres
                }]
            };
            console.log(chartdata);

            // on crée le graphique dans le canvas graphCanvas
            var graphTarget = document.getElementById("graphCanvas");
            var barGraph = new Chart(graphTarget, {
                type: 'line',
                data: chartdata
            });
        }); 
    </script>

</body>
</html>
