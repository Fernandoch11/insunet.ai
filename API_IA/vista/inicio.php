<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="./src/nav_bar.css">
    <link rel="stylesheet" href="./src/table.css">
    <script src="./src/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            /*
            display: flex;
            justify-content: center;
            align-items: center;
            */
        }
    </style>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./functions/functions.js"></script>
    <?php  require('topmenu.php'); ?>
    <script>
            get_stimated_data();
    </script>
    <div class="main_container">
        <div class="main_containerl2">
            <div class="main_containerl3 search-container">
                <input id="searchbox" type="text" placeholder="Buscar...">
                <select id="selectbox">
                    <option value="estimacion_no">ID</option>
                    <option value="usuario">Usuario</option>
                </select>
                <input id="desde" class="inputdate" id="desde" type="date">
                <input id="hasta" class="inputdate" id="hasta" type="date">
                <button class="btn" id="search">Buscar</button>
            </div>
            <div class="container_table">
                <table class="main_table">
                    <thead>
                        <tr class="title_columns">
                            <th class="columnstb">ID</th>
                            <th class="columnstb">Usuario</th>
                            <th class="columnstb">Status</th>
                            <th class="columnstb">Probabilidad</th>
                            <th class="columnstb">Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="addrows">

                    </tbody>
                </table>
            </div>
            <div class="main_containerl3">
                <button class="btn pg" id="prev"><span>&larr;</span> Anterior</button>
                <button class="btn pg" id="next">Siguiente <span>&rarr;</span></button>
                <input type="hidden" id="pageno" value="0">
            </div>
        </div>

        <input type="hidden" id="trueD"  name="trueD" value="">
        <input type="hidden" id="falseD" name="falseD" value="">

        <div class="main_graph_div">
            <h3 class="h3graph" style=""></h3>
            <div id="chart-container">
            <canvas id="miGrafico" width="400" height="200"></canvas>
        <script>
            get_graph();
        </script>
            </div>
            
        </div>
    </div>

</body>
</html>