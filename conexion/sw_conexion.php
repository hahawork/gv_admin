<?php

include ('sw_define.php');

class sw_conexion {

    public function sw_conectar() {
        $res = mysqli_connect(sw_HOSt, sw_USEr, sw_PASSWd, sw_BDMysql);
        mysqli_set_charset($res, "utf8");
        return $res;
    }

}

?>
