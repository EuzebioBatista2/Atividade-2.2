<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Treemap</title>

  <!-- CSS -->
  <link rel="stylesheet" href="styles/styles.css">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-treemap"></script>

  <!-- Bootstrap + JQuery -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">

  <?php
  require_once "Data.php";
  $data = Data::getSortedData()
  ?>
</head>

<body>
  <main>
    <h1 class="title">Análise de crescimento de vendas de refrigerantes: 2023 vs 2024 (±24.5%)</h1>
    <hr />
    <canvas id="myChart"></canvas>
  </main>

  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Editar Volume de Vendas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editForm">
            <div class="form-group">
              <label for="brandName">Marca</label>
              <input type="text" class="form-control" id="brandName" readonly>
            </div>
            <div class="form-group">
              <label for="salesVolume">Volume de Vendas</label>
              <input type="number" class="form-control" id="salesVolume">
            </div>
            <input type="hidden" id="dataIndex">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="saveChanges">Salvar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const brands = <?php echo json_encode($data['brands']); ?>;
    const growthPercentages = <?php echo json_encode($data['growthPercentages']); ?>;
  </script>

  <script src="scripts/chart.js"></script>
</body>

</html>