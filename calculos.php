<?php
session_start();
    session_start();

    if($_POST["cantidad"] > 0 && ($_POST["cantidad"] % 20 == 0) && $_POST["cantidad"] <= 4000 ){
        echo retiro($_POST["cantidad"]);
    } else{
        $resultado = ["trasferencia" => -1];
        echo json_encode($resultado);
    }
    
    

    function billete($i){
        switch($i){
            case 0:
                return 1000;
            case 1:
                return 500;
            case 2:
                return 200;
            case 3:
                return 100;
            case 4:
                return 50;
            case 5:
                return 20;
            default:
                return 0;
        }
    }
    
    function retiro($cantidad){
        $residuo = $cantidad;
        $resta = 1;
        $acumulado = 0;
        $digitoCapturado = 0;
        $cajero = $_SESSION["cajero"];
        $retiro = $_SESSION["retiro"];
        $saldo = $_SESSION["saldo"];
        $billeteRepartido = true;
        
        while($residuo > 0 && $saldo >= $residuo and $billeteRepartido){
            $resta = 0;
            $billeteRepartido = false;
            
            for($i = 0; $i < count($cajero) && $residuo > 0; $i++){
                $resta = billete($i);
                if($resta <= $residuo && $cajero[$i] > 0){
                    if($i+1 < count($cajero)){
                        $resta = billete($i+1);
                        if($cajero[$i+1] > 0 && ($cajero[$i+1]/2) >= $cajero[$i] && ($cajero[$i+1]/2 * $resta) >= $residuo){
                            $i++;
                        } else{
                            $resta = billete($i);
                        } 
                    }
                    $digitoCapturado = (($residuo - $resta) / pow(10, 1)) % 10;
                    if($digitoCapturado != 3 and $digitoCapturado != 1){
                        if(($resta == 20 && $digitoCapturado != 8 || ($resta == 20 && $cajero[$i-1] == 0)) || $resta != 20){
                            $residuo = $residuo-$resta;
                            $acumulado = $acumulado + $resta;
                            $cajero[$i] = $cajero[$i]-1;
                            $retiro[$i] = $retiro[$i]+1;
                            $saldo -= $resta;
                            $billeteRepartido = true;
                        }
                         
                    }
                    
                    
                }
            }
        }
        
        if($residuo == 0){
            $_SESSION["cajero"] = $cajero;
            $_SESSION["retiro"] = [
                0,
                0,
                0,
                0,
                0,
                0];
            $_SESSION["saldo"] = $saldo;
            $_SESSION["clientes"]++;
            $resultado = [
                "trasferencia" => 1,
                "cajero" => $cajero,
                "retiro" => $retiro,
                "saldo" => $saldo,
                "clientes" => $_SESSION["clientes"]
                ];
            return json_encode($resultado);
        } else{
            $_SESSION["errores"]++;
            $resultado = [
                "trasferencia" => 0,
                "cantidad" => $cantidad,
                "saldo" => $saldo,
                "errores" => $_SESSION["errores"]
                ];
            return json_encode($resultado);
        }
        
    }
?>