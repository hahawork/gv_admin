<!DOCTYPE html>
<html>
    <head>    
        <meta charset="utf-8"
              <meta http-equiv="X-UA-Compatible" content="IE=edge">        
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">

        <title>Ejemplo ajax</title>
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>

        <style type="text/css">
            li{
                border: 1px solid #000;
                margin: 3px;
                padding: 5px;
                cursor: pointer;
            }

            #divcontendor{
                border: 1px solid red;
                margin: 2px;
                padding: 10px;
                border-radius: 10px;
                height: 200px;
            }
        </style>
    </head>
    <body>

        <div class="row">
            <div class="col-xs-6">

                <ul>       
                    <?php
                    for ($i = 1; $i <= 6; $i++) {
                        ?>
                        <li onclick="getAjax(<?= $i; ?>)"><?= "Elemento $i"; ?></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="col-xs-6">
                <div id="divcontendor">                    
                </div>
            </div>
        </div>
        <h3>Otro ejemplo</h3>
        <div class="row">
            <div class="col-sm-12">
                <div id="div1"><h2>Ingresa un numero</h2></div>

                <input type="number" id="num" name="num" value="1" />
                <button>Click</button>
            </div>
        </div>
        <script src="../plugins/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

        <script>

                        $(document).ready(function () {
                            $("#divcontendor").html(jQuery.now);
                            
                            $("button").click(function () {
                                $.ajax({
                                    url: "funciones/Obtener.php",
                                    data: {
                                        cantidad: $("#num").val(),
                                        titulo: "Este es el titulo "

                                    },
                                    success: function (result) {
                                        $("#div1").html(result);
                                    }});
                            }
                            );
                        }
                        );

                        function getAjax(idelemento) {

                            $.ajax({
                                type: 'post',
                                dataType: 'json',
                                cache: false,
                                url: "funciones/Obtener.php",
                                data: {
                                    id: idelemento
                                },
                                beforeSend: function (xhr) {
                                },
                                success: function (result) {

                                    if (result.success == 1) {
                                        $("#divcontendor").html(result.uno);
                                    }
                                }

                            });
                        }


        </script>

    </body>
</html>