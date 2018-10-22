<?php
if (isset($_GET["idUsuario"])) {
    $idu = $_GET["idUsuario"];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <style>
            /* Chrome, Safari and Opera syntax */
            :-webkit-full-screen {
                background-color: yellow;
            }

            /* Firefox syntax */
            :-moz-full-screen {
                background-color: yellow;
            }

            /* IE/Edge syntax */
            :-ms-fullscreen {
                background-color: yellow;
            }

            /* Standard syntax */
            :fullscreen {
                background-color: yellow;
            }

            .contenedor{
                text-align: center;
                background-color: blue;
                color: white;
            }
            /* Style the button */
            button {
                padding: 20px;
                font-size: 20px;
            }
        </style>
    </head>
    <body>

        <div class="contenedor" ng-app="myApp" ng-controller="myCtrl">

            <img src="../images/emoji-llorando.png" width="300">

            <h2>{{Name}} lamentamos que te vallas.</h2>
            <p>Click on the "Open Fullscreen" button to open this page in fullscreen mode. Close it by either clicking the "Esc" key on your keyboard, or with the "Close Fullscreen" button.</p>

            <button id="btnopen" onclick="openFullscreen();">Open Fullscreen</button>
            <button onclick="closeFullscreen();">Close Fullscreen</button>
        </div>
        <script src="../vendor/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script>

                var app = angular.module('myApp', []);
                app.controller('myCtrl', function ($scope) {
                    $scope.iduser = "<?=$idu?>";
                    $scope.Name = "Doe";
                });



                var elem = document.documentElement;

                $(document).ready(function () {
                    
                });

        </script>
    </body>
</html>