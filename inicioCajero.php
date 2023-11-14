<?php
    session_start();
    
    $retiro = [
        0,
        0,
        0,
        0,
        0,
        0
    ];
    $errores = 0;
    if($_SESSION["ok"] == 1){
        
        
        $cajero = [
            comprobar(filter_var($_POST["mil"],FILTER_VALIDATE_INT)) ?? "0",
            comprobar(filter_var($_POST["quinientos"],FILTER_VALIDATE_INT)) ?? "0",
            comprobar(filter_var($_POST["docientos"],FILTER_VALIDATE_INT)) ?? "0",
            comprobar(filter_var($_POST["cien"],FILTER_VALIDATE_INT)) ?? "0",
            comprobar(filter_var($_POST["cincuenta"],FILTER_VALIDATE_INT)) ?? "0",
            comprobar(filter_var($_POST["veinte"],FILTER_VALIDATE_INT)) ?? "0"
        ];
        $_SESSION["cajero"] = $cajero;
        $_SESSION["retiro"] = $retiro;
        $_SESSION["saldo"] = $cajero[0] * 1000 + $cajero[1] * 500 + $cajero[2] * 200 + $cajero[3] * 100 + $cajero[4] * 50 + $cajero[5] * 20;
        $_SESSION["ok"] = 0;
        $_SESSION["clientes"] = 0;
        $_SESSION["errores"] = 0;
    }
    function comprobar($valor){
        if($valor > 100){
            return 100;
        } else if($valor < 0){
            return 0;
        } else {
            return $valor;
        }
        
    }
    
    
    
    
    
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/cajero.css">
        <title>Cajero Simulation</title>
    </head>
    <body>
        <div class = "caja_cantidad">
                <ol>
                    <li><span>1000: </span> <span id = "$_caja1"><?= $cajero[0];?></span></li>
                    <li><span>500: </span> <span id = "$_caja2"><?= $cajero[1];?></span></li>
                    <li><span>200: </span> <span id = "$_caja3"><?= $cajero[2];?></span></li>
                    <li><span>100: </span> <span id = "$_caja4"><?= $cajero[3];?></span></li>
                    <li><span>50: </span> <span id = "$_caja5"><?= $cajero[4];?></span></li>
                    <li><span>20: </span> <span id = "$_caja6"><?= $cajero[5];?></span></li>
                </ol>
        </div>
        <div class = "Margen">
            <h1>Simulador de Cajero (ATM)</h1>
            <div class = "tarjetas">
                <div class = 'informacion'>
                    <h2>Establesca las cantidades...</h2>
                    <h4 id = "saldo">Saldo restante: <?= $_SESSION["saldo"]; ?></h4>
                    <h5>* Solo cantidades maximas de 4000</h5>
                    <label for="cantidad" id = "labelCantidad">¿Cuanto busca retirar?</label>
                    <input type="text" name = "cantidad" id = "cantidad">
                    
                    <label id = "resultado"></label>
                </div>
        
                <div class = "retiro_cantidad">
                    <ol>
                        <li>1000:   <span id = "$_retiro1">0</span></li>
                        <li>500:    <span id = "$_retiro2">0</span></li>
                        <li>200:    <span id = "$_retiro3">0</span></li>
                        <li>100:    <span id = "$_retiro4">0</span></li>
                        <li>50:     <span id = "$_retiro5">0</span></li>
                        <li>20:     <span id = "$_retiro6">0</span></li>
                    </ol>
                </div>
            </div>
            <div class = "botones">
                <button onclick = 'operacion()' type = 'button'>Aceptar</button>
                <button onclick = 'reiniciar()' type = 'button'>Riniciar</button>
                <button onclick = 'aleatorio()' type = 'button'>Aleatorio</button>
            </div>
        </div>
        
        <footer>
            <span><span id = "clientes">0</span> | <span id = "errores">0</span></span>
        </footer>
        
        <script>
            const htmlResultado = document.getElementById('resultado');
            const htmlCantidad = document.getElementById('cantidad');
            const htmlClientes = document.getElementById('clientes');
            const htmlErrores = document.getElementById('errores');
    
            const caja1 = document.getElementById('$_caja1');
            const caja2 = document.getElementById('$_caja2');
            const caja3 = document.getElementById('$_caja3');
            const caja4 = document.getElementById('$_caja4');
            const caja5 = document.getElementById('$_caja5');
            const caja6 = document.getElementById('$_caja6');
    
            const retiro1 = document.getElementById('$_retiro1');
            const retiro2 = document.getElementById('$_retiro2');
            const retiro3 = document.getElementById('$_retiro3');
            const retiro4 = document.getElementById('$_retiro4');
            const retiro5 = document.getElementById('$_retiro5');
            const retiro6 = document.getElementById('$_retiro6');
    
            const htmlSaldo = document.getElementById('saldo');
            
            
            function operacion(){
                var objetoJS;
                const formData = new FormData();
    
                formData.append('cantidad', htmlCantidad.value);
                fetch("calculos.php",{
                    body: formData,
                    method: "POST"
                })
                .then(res => res.text())
                .then(data => {
       
                    objetoJS = JSON.parse(data);
                    console.log(data); // Datos recividos
                    
                    if(objetoJS["trasferencia"] == 1){ // Operacion Correcta
                        console.log(objetoJS["cajero"]);
                        
                        htmlSaldo.innerHTML = "Saldo Actual: " + objetoJS["saldo"];
                        alert("Retiro exitoso!");
                        htmlClientes.innerHTML = objetoJS["clientes"];
                        
                        caja1.innerHTML = objetoJS["cajero"][0];
                        caja2.innerHTML = objetoJS["cajero"][1];
                        caja3.innerHTML = objetoJS["cajero"][2];
                        caja4.innerHTML = objetoJS["cajero"][3];
                        caja5.innerHTML = objetoJS["cajero"][4];
                        caja6.innerHTML = objetoJS["cajero"][5];
    
                        retiro1.innerHTML = objetoJS["retiro"][0];
                        retiro2.innerHTML = objetoJS["retiro"][1];
                        retiro3.innerHTML = objetoJS["retiro"][2];
                        retiro4.innerHTML = objetoJS["retiro"][3];
                        retiro5.innerHTML = objetoJS["retiro"][4];
                        retiro6.innerHTML = objetoJS["retiro"][5];
                        
                    } else if(objetoJS["trasferencia"] == -1){ // Cantidad errone segun las condicionales
                        alert("Cantidad invalida");
                    } else {
                        alert("Saldo insuficiente"); // Saldo insuficiente u otro error
                        htmlErrores.innerHTML = objetoJS["errores"];
                    }
    
    
                });  
                
                
                
            }
            
            function reiniciar(){
                alert("Se ha borrado el registro");
                window.location.href = "index.php";
            }
            
            function aleatorio(){
                var numeroAleatorio = getRandomInt(2, 400);
                if((numeroAleatorio % 2) == 0 && numeroAleatorio <= 400){
                    numeroAleatorio = numeroAleatorio*10;
                    htmlCantidad.value = numeroAleatorio;
                    
                    operacion();

                } else{
                    aleatorio();
                }
            }
            function getRandomInt(min, max) {
              min = Math.ceil(min);
              max = Math.floor(max);
              return Math.floor(Math.random() * (max - min + 1)) + min;
            }
        </script>
        
    </body>
</html>