<?php
include './Class/config.php';
$now = (string) date("Y-m-d H:i:s");
$pruebaTecnica = new config($now);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $pruebaTecnica->tittle ?></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.0/css/bulma.min.css">
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- Incluyo librerias de CSS, Iconos, Ajax y JQuery-->

    </head>
    <body>
        <section class="col-12">
            <div class="container">
                <h1 class="title">
                    <?= $pruebaTecnica->tittle ?>
                </h1>
                <p class="subtitle">
                    Powered By <strong><?= $pruebaTecnica->powered_by ?></strong>!<br>
                    Conexión realizada a las: <strong><?= $pruebaTecnica->date_now ?></strong>!
                </p>
                <div id="floating-div">
                  <p>Contenido del div flotante</p>
                  <button id="close-button">Cerrar</button>
                </div>      
            </div>
        </section>      
        <div class="container center">
            <form id="formHome" name="formHome" onsubmit="return false;">                                   
                <div class="card col-12">
                    <div class="field col-12">
                        <label class="label">Ejercicios:</label>
                        <p class="control has-icons-left">
                            <span class="select">
                                <select class="form-select is-large" style="width: 100%" id="txtTipoEjecicio" name="txtTipoEjecicio" onchange="joinTest(this.value);" required>
                                    <option disabled selected>Seleccione un ejercicio</option>                             
                                    <?php
                                    $data = (object) $pruebaTecnica->show_test_list();
                                    if (is_object($data)) {
                                        foreach ($data as $value) {
                                            echo '<option value="' . $value['value'] . '">' . $value['name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </span>
                            <span class="icon is-small is-left">
                                <i class="fa fa-book"></i>
                            </span>
                        </p>
                    </div>  
                    <div id="dvSelect" class="field col-12" style="display: none">
                        <p class="control has-icons-left">
                            <span class="select">
                                <select class="form-select is-large" style="width: 100%" id="txtFigura" name="txtFigura" required>
                                    <option disabled selected>Seleccione una figura</option>                             
                                    <option value="1">Cuadrado</option>
                                    <option value="2">Triangulo</option>
                                    <option value="3">Circulo</option>
                                </select>
                            </span>
                            <span class="icon is-small is-left">
                                <i class="fa fa-circle"></i>
                            </span>
                        </p>                        
                    </div>                     
                    <div class="field col-12">
                        <label id="titleAmount" name="titleAmount" class="label" style="display: none">Cantidad</label>
                        <label id="titleAmountQuantum" name="titleAmountQuantum" class="label" style="display: none">Cantidad Quantum</label>
                        <div class="control">
                            <input id="txtAmount" name="txtAmount" class="input" type="number" placeholder="Cantidad" style="display: none">
                        </div>
                    </div>
                    <label id="titleAmountQuantum1" name="titleAmountQuantum1" class="label" style="display: none">Procesos</label>
                    <div class="field col-12" id="dv20Fields" name="dv20Fields" style="display: none">
                        <?php
                        for ($index = 1; $index <= 20; $index++) {
                            echo'<div class="control">
                                    <input id="txtNumber' . $index . '" name="txtNumber' . $index . '" class="input" type="number" placeholder="Numero' . $index . '">
                                </div>';
                        }
                        ?>
                    </div>                     
                    <div class="field col-12" id="dv10Fields" name="dv10Fields" style="display: none">
                        <?php
                        for ($index = 1; $index <= 5; $index++) {
                            echo'<div class="control">
                                    <input id="txtNumber' . $index . '" name="txtNumbers' . $index . '" class="input" type="text" placeholder="Proceso' . $index . '">
                                </div>';
                        }
                        ?>   
                    <label id="titleAmountQuantum2" name="titleAmountQuantum2" class="label" style="display: none">Tiempo Procesos</label>
                        
                        <?php
                        for ($index = 1; $index <= 5; $index++) {
                            echo'<div class="control">
                                    <input id="txtTime' . $index . '" name="txtTime' . $index . '" class="input" type="number" placeholder="Tiempo Proceso' . $index . '">
                                </div>';
                        }
                        ?>
                    </div>                     
                    <div class="field col-12">                                               
                        <div id="btnContinue" style="display: none">
                            <button id="btnConfirm" name="btnConfirm" class="btn-primary" type="submit" >Continuar</button>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Respuesta:</label>
                        <div id="idResponse" name="idResponse" align="center"></div>
                    </div>                    
                </div>
            </form>
        </div>
    </body>
</html>

<script language="javascript">
    var functions = '';
    var vidTest = 0;

    function joinTest(idTest) {
        ocultar_cantidad();
        document.getElementById("idResponse").innerHTML = '';
        $.ajax({
            type: "POST",
            url: "/Functions/function.php",
            data: "name_function=joinTest&idTest=" + idTest,
            success: function (text) {
                var obj = JSON.parse(text);
                if (obj.status == "success") {
                    show_result(obj.data);
                } else if (obj.status == "step") {//requiere otros pasos      
                    functions = obj.function;
                    vidTest = idTest;
                    if (obj.data == "show_amount") {
                        show_amount();
                    } else if (obj.data == 'show_20_fields') {
                        ocultar_cantidad();
                        show_20_fields();
                    } else if (obj.data == 'show_select'){
                        ocultar_cantidad();
                        show_select();
                    } else if (obj.data == 'show_robin_pars'){
                        show_robin_pars();
                    }
                } else {
                    show_result(obj.data);
                }
            },
            error: function () {
                show_result('SE HA PRESENTADO UN ERROR');
            }
        });
    }

    $("#btnConfirm").click(function () {
        form = formHome;
        var data = JSON.stringify($(form).serializeArray());
        $.ajax({
            type: "POST",
            url: "/Functions/function.php",
            data: "name_function=" + functions + "&idTest=" + vidTest + "&parms=" + data,
            success: function (text) {
                var obj = JSON.parse(text);

                if (obj.status == "success") {
                    show_result(obj.data);
                } else if (obj.status == "step") {
                    functions = obj.function;
                    vidTest = idTest;
                    if (obj.data === "show_amount") {
                        show_amount();
                    }
                } else {
                    show_result(obj.data);
                }
            },
            error: function () {
                show_result('SE HA PRESENTADO UN ERROR');
            }
        });
    });

    function show_robin_pars() {
        $('#txtAmount').show();
        $('#titleAmountQuantum').show();
        $('#titleAmountQuantum1').show();
        $('#titleAmountQuantum2').show();
        $('#btnContinue').show();
        $('#dv10Fields').show();
        $('#dv20Fields').hide();
    }
    function show_amount() {
        $('#txtAmount').show();
        $('#titleAmount').show();
        $('#btnContinue').show();
        $('#dv20Fields').hide();
        $('#titleAmountQuantum').hide();                
        $('#titleAmountQuantum1').hide();
        $('#titleAmountQuantum2').hide();   
        $('#dv10Fields').hide();
        
    }
    function ocultar_cantidad() {
        $('#txtAmount').hide();
        $('#titleAmount').hide();   
        $('#titleAmountQuantum').hide();   
        $('#titleAmountQuantum1').hide();
        $('#titleAmountQuantum2').hide();           
        $('#btnContinue').hide();
        $('#dv20Fields').hide();
        $('#dv10Fields').hide();
    }
    function show_20_fields() {
        $('#dv20Fields').show();
        $('#btnContinue').show();
    }
    function show_select() {
        $('#dvSelect').show();
        $('#btnContinue').show();
    }
    function show_result(data) {
        document.getElementById("idResponse").innerHTML = "<hr><h1>" + data + "</h1><hr>";
    }
 // Obtener el div flotante y el botón de cierre
var floatingDiv = document.getElementById('floating-div');
var closeButton = document.getElementById('close-button');

// Agregar un controlador de eventos para el botón de cierre
closeButton.addEventListener('click', function() {
  // Ocultar el div flotante cuando se hace clic en el botón de cierre
  floatingDiv.style.display = 'none';
});

// Agregar controladores de eventos para el movimiento del div flotante
floatingDiv.addEventListener('mousedown', dragStart);
floatingDiv.addEventListener('mouseup', dragEnd);

// Función para comenzar a arrastrar el div flotante
function dragStart(e) {
  this.posX = e.clientX - this.offsetLeft;
  this.posY = e.clientY - this.offsetTop;
  this.style.cursor = 'move';
  document.addEventListener('mousemove', drag);
}

// Función para arrastrar el div flotante
function drag(e) {
    console.log(e);
  this.style.top = (e.clientY - this.posY) + 'px';
  this.style.left = (e.clientX - this.posX) + 'px';
}

// Función para detener el arrastre del div flotante
function dragEnd() {
  this.style.cursor = 'default';
  document.removeEventListener('mousemove', drag);
}

</script>
<style>
#floating-div {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 9999;
  background-color: white;
  border: 1px solid black;
  padding: 10px;
}

#close-button {
  position: absolute;
  top: 0;
  right: 0;
} 
</style>
