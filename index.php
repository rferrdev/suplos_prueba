<?php include 'scripts/searchOptions.php'; ?>

<?php
//mostrar todos
$todos = false;
$filtrados = false;
if (isset($_POST['mostrarTodos'])) {
  $todos = true;
  $filtrados = false;
}
if (isset($_POST['buscar'])) {
  $todos = false;
  $filtrados = true;
}

//obtener datos
$dataJSON = file_get_contents('data-1.json', FILE_USE_INCLUDE_PATH);
$data = json_decode($dataJSON);

include_once 'scripts/searchFilter.php';
include_once 'scripts/toFav.php';
include_once 'scripts/showFav.php';
include_once 'scripts/removeFav.php';
include_once 'scripts/genReport.php';
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/customColors.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" media="screen,projection" />
  <link type="text/css" rel="stylesheet" href="css/index.css" media="screen,projection" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Formulario</title>
</head>

<body>
  <video src="img/video.mp4" id="vidFondo"></video>

  <div class="contenedor">
    <div class="card rowTitulo">
      <h1>Bienes Intelcost</h1>
    </div>
    <div class="colFiltros">
      <form action="index.php" method="post" id="formulario">
        <div class="filtrosContenido">
          <div class="tituloFiltros">
            <h5>Filtros</h5>
          </div>
          <div class="filtroCiudad input-field">
            <p><label for="selectCiudad">Ciudad:</label><br></p>
            <select name="ciudad" id="selectCiudad">
              <option value="" disabled selected>Elige una ciudad</option>
              <?php
              if (mysqli_num_rows($ciudadList) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($ciudadList)) {
                  echo '<option name="ciudad" value="' . $row["ciudad"] . '">' . $row["ciudad"] . '</option><br/>';
                }
              } else {
                echo "0 results";
              }
              ?>
            </select>
          </div>
          <div class="filtroTipo input-field">
            <p><label for="selecTipo">Tipo:</label></p>
            <br>
            <select name="tipo" id="selectTipo">
              <option disabled selected value="">Elige un tipo</option>
              <?php
              if (mysqli_num_rows($tipoList) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($tipoList)) {
                  echo '<option name="tipo" value="' . $row["tipo"] . '">' . $row["tipo"] . '</option><br/>';
                }
              } else {
                echo "0 results";
              }
              ?>
            </select>
          </div>
          <div class="filtroPrecio">
            <label for="rangoPrecio">Precio:</label>
            <input type="text" id="rangoPrecio" name="precio" value="" />
          </div>
          <div class="botonField">
            <input type="submit" class="btn white" value="Buscar" name="buscar" id="submitButton">
          </div>
        </div>
      </form>
    </div>
    <div id="tabs" style="width: 75%;">
      <ul>
        <li><a href="#tabs-1">Bienes disponibles</a></li>
        <li><a href="#tabs-2">Mis bienes</a></li>
        <li><a href="#tabs-3">Reportes</a></li>
      </ul>
      <div id="tabs-1">
        <div class="colContenido" style="min-width: 100%;" id="divResultadosBusqueda">
          <div class="tituloContenido card" style="justify-content: center;">
            <h5>Resultados de la búsqueda:</h5>
            <form action="index.php" method="post">
              <div class="botonField">
                <input type="submit" class="btn white" value="Mostrar todos" name="mostrarTodos" id="">
              </div>
            </form>
            <div class="divider"></div>
            <?php if ($todos) {
              foreach ($data as $item) {
                echo '
                  <hr class="divider" id="blackhr">
                  <div class="row">
                    <div class="col s6">
                      <img src="img/home.jpg" id="cardImage1">
                    </div>
                    <div class="col s6">
                      <p style="display:none">id: ' . $item->Id . '</p>
                      <p>Dirección: ' . $item->Direccion . '</p>
                      <p>Ciudad: ' . $item->Ciudad . '</p>
                      <p>Teléfono: ' . $item->Telefono . '</p>
                      <p>Código Postal: ' . $item->Codigo_Postal . '</p>
                      <p>Tipo: ' . $item->Tipo . '</p>
                      <p>Precio: ' . $item->Precio . '</p>
                      <form action="index.php" method="post">
                      <button name="favoriteBtn" value="' . $item->Id . '" class="btn-floating btn-large waves-effect waves-light green">
                        <i class="material-icons">favorite</i>
                      </button>
                      </form>
                    </div>
                  </div>
                ';
              }
            }  ?>
            <?php if ($filtrados) {
              foreach ($filterData as $filterItem) {
                echo '
                  <hr class="divider" id="blackhr">
                  <div class="row">
                    <div class="col s6">
                      <img src="img/home.jpg" id="cardImage1">
                    </div>
                    <div class="col s6">
                      <p style="display:none">id: ' . $filterItem['id'] . '</p>
                      <p>Dirección: ' . $filterItem['direccion'] . '</p>
                      <p>Ciudad: ' . $filterItem['ciudad'] . '</p>
                      <p>Teléfono: ' . $filterItem['telefono'] . '</p>
                      <p>Código Postal: ' . $filterItem['cpostal'] . '</p>
                      <p>Tipo: ' . $filterItem['tipo'] . '</p>
                      <p>Precio: ' . $filterItem['precio'] . '</p>
                      <form action="index.php" method="post">
                      <button name="favoriteBtn" value="' . $filterItem['id'] . '" class="btn-floating btn-large waves-effect waves-light green">
                        <i class="material-icons">favorite</i>
                      </button>
                      </form>
                    </div>
                  </div>
                ';
              }
            }  ?>

          </div>
        </div>
      </div>
      <div id="tabs-2">
        <div class="colContenido" style="min-width: 100%;" id="divResultadosBusqueda">
          <div class="tituloContenido card" style="justify-content: center;">
            <h5>Bienes guardados:</h5>
            <div class="divider"></div>
            <?php
            if (!$favList) {
              echo "<p>No hay favoritos guardados</p>";
            }
            foreach ($favList as $bienFavorito) {
              echo '
                  <hr class="divider" id="blackhr">
                  <div class="row">
                    <div class="col s6">
                      <img src="img/home.jpg" id="cardImage1">
                    </div>
                    <div class="col s6">
                      <p style="display:none">id: ' . $bienFavorito['id'] . '</p>
                      <p>Dirección: ' . $bienFavorito['direccion'] . '</p>
                      <p>Ciudad: ' . $bienFavorito['ciudad'] . '</p>
                      <p>Teléfono: ' . $bienFavorito['telefono'] . '</p>
                      <p>Código Postal: ' . $bienFavorito['cpostal'] . '</p>
                      <p>Tipo: ' . $bienFavorito['tipo'] . '</p>
                      <p>Precio: ' . $bienFavorito['precio'] . '</p>
                      <form action="index.php" method="post">
                      <button name="removeFav" value="' . $bienFavorito['id'] . '" class="btn-floating btn-large waves-effect waves-light red">
                        <i class="material-icons">remove_circle</i>
                      </button>
                      </form>
                    </div>
                  </div>
                ';
            }
            ?>
          </div>
        </div>
      </div>
      <div id="tabs-3">
        <div class="colContenido" style="min-width: 100%;" id="divResultadosBusqueda">
          <div class="tituloContenido card" style="justify-content: center;">
            <h5>Exportar reportes:</h5>
            <div class="divider"></div>
            <div class="">
              <form action="index.php" method="post" id="formulario">
                <div class="filtrosContenido">
                  <div class="tituloFiltros">
                    <h5>Filtros</h5>
                  </div>
                  <div class="filtroCiudad input-field">
                    <p><label for="selectCiudad">Ciudad:</label><br></p>
                    <?php include 'scripts/searchOptions.php'; ?>
                    <select name="ciudad" id="selectCiudad">
                      <option value="" disabled selected>Elige una ciudad</option>
                      <?php
                      if (mysqli_num_rows($ciudadList) > 0) {
                        // output data of each row
                        while ($row = mysqli_fetch_assoc($ciudadList)) {
                          echo '<option name="ciudad" value="' . $row["ciudad"] . '">' . $row["ciudad"] . '</option><br/>';
                        }
                      } else {
                        echo "0 results";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="filtroTipo input-field">
                    <p><label for="selecTipo">Tipo:</label></p>
                    <br>
                    <select name="tipo" id="selectTipo">
                      <option disabled selected value="">Elige un tipo</option>
                      <?php
                      if (mysqli_num_rows($tipoList) > 0) {
                        // output data of each row
                        while ($row = mysqli_fetch_assoc($tipoList)) {
                          echo '<option name="tipo" value="' . $row["tipo"] . '">' . $row["tipo"] . '</option><br/>';
                        }
                      } else {
                        echo "0 results";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="botonField">
                    <input type="submit" class="btn white" value="Generar Excel" name="reporte" id="submitButton">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

  <script type="text/javascript" src="js/ion.rangeSlider.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/index.js"></script>
  <script type="text/javascript" src="js/buscador.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#tabs").tabs();
    });
  </script>
</body>

</html>