<?php

include('../Class/config.php');
$errorData = "";

if (empty($_POST["name_function"])) {
    $errorData = "La funcion es obligatoria";
} else {
    $function = $_POST["name_function"];
}

if (empty($_POST["idTest"])) {
    $errorData = "El id de la prueba, es obligatorio";
} else {
    $id_test = $_POST["idTest"];
}

function secuenceF() {
    $data = Array();
    $data[0] = 0;
    $data[1] = 1;
    $return = '';

    for ($i = 2; $i < 11; $i++) {
        $return .= ($data[$i - 1] + $data[$i - 2]) . ',';
        $data[$i] = ($data[$i - 1] + $data[$i - 2]);
    }
    $json_response['status'] = 'success';
    $json_response['data'] = rtrim($return, ',');
    return json_encode($json_response);
}

function showLadderInv($parm = '') {
    $amount = 0;
    foreach (json_decode($parm) as $value) {
        if ((String) $value->name == (String) 'txtAmount') {
            $amount = $value->value;
        }
    }

    if ($amount > 0) {
        $return = '';
        $pos = 0;

        for ($ciclo = 0, $pos = ($amount * 2) - 1; $pos > 0; $ciclo++, $pos -= 2) {
            for ($ciclo2 = $pos; $ciclo2 > 0; $ciclo2--) {
                $return .= '*';
            }
            $return .= '<br>';
        }
    } else {
        $return = "Ingrese una cantidad válida mayor a 0";
    }
    $json_response['status'] = 'success';
    $json_response['data'] = $return;
    return json_encode($json_response);
}

function sheep($parm = '') {
    $arr_response = [];
    $ciclo = 1;
    $ovejas[] = array('name' => 'Noa', 'Color' => 'azul'); 
    $ovejas[] = array('name' => 'Euge', 'Color' => 'rojo'); 
    $ovejas[] = array('name' => 'Navidad', 'Color' => 'rojo'); 
    $ovejas[] = array('name' => 'Ki Na Me', 'Color' => 'rojo'); 
    $ovejas[] = array('name' => 'AAAAAaaaaa', 'Color' => 'rojo'); 
    $ovejas[] = array('name' => 'Nnnnnnnn', 'Color' => 'rojo');     
    $data = json_encode($ovejas); //Arreglo Json
    $return='';
    
    foreach (json_decode($data) as $value) {
        if($value->Color == 'rojo'){
            if(strstr($value->name, "A") !== false || strstr($value->name, "a") !== false || strstr($value->name, "N") !== false || strstr($value->name, "n") !== false){
               $return .= $value->name. ',';
            }
        }
    }
    
    $json_response['status'] = 'success';
    $json_response['data'] = "<h6>".$data."</h6><br><h1>".$return;
    return json_encode($json_response);

}


function majorAndMinor($parm = '') {
    $return = array();
    foreach (json_decode($parm) as $value){
        if(is_numeric($value->value) AND strstr($value->name, "txtNumber") !== false){
           $return[] = $value->value;
        }
    }
    $json_response['status'] = 'success';
    $json_response['data'] = "Mayor:".max($return)."<br> Menor:". min($return);    
    return json_encode($json_response);    
}

function comparar($pattern, $subject)
{
    $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
    return (bool) preg_match("/^{$pattern}$/i", $subject);
}

function showRoundRobin($parm = '') {
    $quantum = 0;
    foreach (json_decode($parm) as $value) {
        if ((String) $value->name == (String) 'txtAmount') {
            $quantum = $value->value;
        }
        if(comparar('%proceso%',$value->name)){
            if(isset($value->value) && !empty($value->value)){
                $procesos[$value->name] = $value->value;
            }else{
                //$mensaje = "El proceso #<b>". $value->name . " Es obligatorio</b>";                    
            }
        }
        if(comparar('%numero%',$value->name)){
            if(isset($value->value) && !empty($value->value)){  
                $tiempos_ejecucion[] = $value->value;   
            }else{                
                //$mensaje = "El tiempo del proceso #<b>". $value->name . " Es obligatorio</b>";                                    
            }
        }
    }

//    if(isset($mensaje) && !empty($mensaje)){
//        $response = "<tr><td align='left'>". $mensaje . "</td></tr>";
//        $json_response['status'] = 'success';
//        $json_response['data'] = $response;    
//        return json_encode($json_response);          
//    }

    $tiempos_restantes = $tiempos_ejecucion;
    $tiempos_espera = array_fill(0, count($procesos), 0);//indice,acntidad,nombre
    $tiempo_total = 0;

    while (true) {
      $finalizo = true;
      // recorro cada proceso
      for ($i = 0; $i < count($procesos); $i++) {
        // tiempo restante
        if ($tiempos_restantes[$i] > 0) {
          $finalizo = false;

          // tiempo restantees mayor que el quantum
          if (isset($quantum) && !empty($quantum) && $tiempos_restantes[$i] > $quantum) {
            $tiempo_total += $quantum;
            $tiempos_restantes[$i] -= $quantum;
          } else {
            $tiempo_total += $tiempos_restantes[$i];
            $tiempos_espera[$i] = $tiempo_total - $tiempos_ejecucion[$i];
            $tiempos_restantes[$i] = 0;
          }
        }
      }

      if ($finalizo) {
        break;
      }
    }

    $tiempo_espera_promedio = array_sum($tiempos_espera) / count($procesos);

    $mensaje = "El Tiempo total de ejecución es: <b>". $tiempo_total . "</b><br>"
                 . "El Tiempo de espera promedio es: <b>" .$tiempo_espera_promedio . "</b>";    
    $response = "<tr><td align='left'>". $mensaje . "</td></tr>";
  
    
    $json_response['status'] = 'success';
    $json_response['data'] = $response;    
    return json_encode($json_response);  
}

function perimeterAndArea($parm = '') {
    foreach (json_decode($parm) as $value){
        if(strstr($value->name, "txtFigura") !== false){
           $id_figura = $value->value;
        }
        if(strstr($value->name, "txtLongitud") !== false){
           $longitud_lado = $value->value;
        }
        if(strstr($value->name, "txtBase") !== false){
           $base = $value->value;
        }
        if(strstr($value->name, "txtRadio") !== false){
           $radio = $value->value;
        }
        if(strstr($value->name, "txtAltura") !== false){
           $altura = $value->value;
        }
    }
        
    if ($id_figura == 1) {
        $area = $longitud_lado * $longitud_lado;
        $perimetro = $longitud_lado * 4;
        $mensaje = "El Area es: <b>". $area . "</b>,"
                 . "El Perimetro es: <b>" .$perimetro . "</b>";
    } else if ($id_figura == 3) {
        $perimetro = round(3.14 * $radio * 2);        
        $area = (3.14 * $radio ** 2);
        $mensaje = "El Area es: <b>" . $area . "</b>,"
                .  "El Perimetro es: <b>" . $perimetro ."</b>";
    } else if ($id_figura == 2) {
        $area = $base * $altura;
        $perimetro = ($base + $altura + sqrt($base * $base + $altura * $altura));
        $mensaje = "El Area es: <b>" . $area . "</b>, "
                .  "El Perimetro es: <b>" . $perimetro . "</b>";

        //Circulo
    }

    $response = "<tr><td align='left'>". $mensaje . "</td></tr>";
    //document.getElementById("dvResultado").innerHTML = $response;
  
    
    $json_response['status'] = 'success';
    $json_response['data'] = $response;    
    return json_encode($json_response);    
}

function showLadder($parm = '') {
    $amount = 0;
    foreach (json_decode($parm) as $value) {
        if ((String) $value->name == (String) 'txtAmount') {
            $amount = $value->value;
        }
    }

    if ($amount > 0) {
        $return = "<table>";
        for ($ciclo = 0; $ciclo <= $amount; $ciclo++) {
            $return .= "<tr><td>";
            for ($i = 0; $i < $ciclo; $i++) {
                $return .= "*";
            }
            $return .= "</td>";
        }
        $return .= "</tr><br></table>";
    } else {
        $return = "Ingrese una cantidad válida mayor a 0";
    }
    $json_response['status'] = 'success';
    $json_response['data'] = $return;
    
    return json_encode($json_response);
}

function joinTest($idTest = 0) {
    $pruebaTecnica = new config();
    
    $function = $pruebaTecnica->show_function($idTest);
    $parameters = $pruebaTecnica->show_parms($idTest);
    $fParameters = $pruebaTecnica->show_function_parms($idTest);
    
    if ($parameters == "true") {//si tiene otro paso (cantidad/select/input) redirecciona y asigna la funcion al boton confirmar        
        $json_response['status'] = 'step';
        $json_response['data'] = $fParameters;
        $json_response['function'] = $function;
        
        return json_encode($json_response);
    } else {
        if (isset($function) && !empty($function)) {
            echo $function();
        } else {
            $json_response['status'] = 'error';
            $json_response['data'] = "No se ha encontrado la funcion de la prueba #" . $idTest;
            
            return json_encode($json_response);
        }
    }
}

if ($errorData == "") {
    if (isset($_POST['parms']) && !empty($_POST['parms'])) {
        echo $function($_POST['parms']);
    } else {
        echo $function($id_test);
    }
} else {
    echo $errorData;
}
?>