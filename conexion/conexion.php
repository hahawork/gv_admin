<?php

include ('define.php');

class conexion {

    public function conectar() {
        $res = mysqli_connect(HOSt, USEr, PASSWd, BDMysql);
        mysqli_set_charset($res, "utf8");
        return $res;
    }

}
?>
