<?php
    session_start();
    $_SESSION["ok"] = "1";
    
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title>Cajero Simulation</title>
</head>
<body>
    <header> </header>
    <div class = "Margen">
        <h1>Simulador de Cajero</h1>
        <h2>Establesca las cantidades...</h2>
        <hr>
        <form action="inicioCajero.php" method="post">
            <!-- el codigo se guia por name -->
            <label for="mil">1000</label> <!-- for con mimso id para enlazar -->
            <input type="text" name = "mil" id = "mil" value="0">
    
            <label for="quinientos">500</label>
            <input type="text" name = "quinientos" id = "quinientos" value="0">
            
            <label for="docientos">200</label> <!-- for con mimso id para enlazar -->
            <input type="text" name = "docientos" id = "docientos" value="0">
    
            <label for="cien">100</label>
            <input type="text" name = "cien" id = "cien" value="0">
            
            <label for="cincuenta">50</label>
            <input type="text" name = "cincuenta" id = "cincuenta" value="0">
            
            <label for="veinte">20</label>
            <input type="text" name = "veinte" id = "veinte" value="0">
    
            <button name = "form" type = 'submit'>Guardar</button>
            <!-- Por defecto los botones son de tipo submit -->
        </form>
    </div>
    <footer></footer>
</body>
</html>