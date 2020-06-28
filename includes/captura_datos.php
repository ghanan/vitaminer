<?php

    require_once('login.php');

    function vitaminer_captura_datos() {
        if($_POST['vitaminer_hidden'] == 'Y') {
            $resultado = comprueba_datos();
            if ($resultado === true) {
                print('Correcto');
                //~ vitaminer_graba_datos();
            } else {
                vitaminer_pide_datos($resultado);
            }
        } else {
            vitaminer_pide_datos();
        }
    }

    function vitaminer_pide_datos($msge = "") {
        print("<div class='wrap'>");
        print($msge);
        print('<h2>Introducción de datos de vitaminas y minerales</h2>');
        print('<form name="vitaminer_form" method="post" action=' . $_SERVER['REQUEST_URI'] . '>');
        print('<input type="hidden" name="vitaminer_hidden" value="Y">');
        print('Vitamina o mineral: <input type="text" name="nombre" size="20"><br />');
        print('Cantidad mínima: <input type="text" name="minimo" size="20"><br />');
        print('Cantidad recomendada: <input type="text" name="recomendado" size="20"><br />');
        print('Beneficios: <input type="text" name="beneficios" size="80"><br />');
        print('Alimentos: <input type="text" name="alimentos" size="80"><br />');
        print('Notas: <input type="text" name="notas" size="80"><br />');
        print('<input type="submit" value="Grabar" style="color: #ff0000">');
        print('</form>');
        print('</div>');
    }

    function comprueba_datos() {
        $nombre = $_POST['nombre'];
        if (!$nombre) return "ERROR: Nombre sin rellenar";
        if (existe_nombre($nombre)) {
            $respuesta = cancelar_o_sustituir();
        }
        return true;
    }

    function existe_nombre($nombre) {
        return false;
    }

    function cancelar_o_sustituir() {
        return "cancelar";
    }

    function vitaminer_graba_datos() {
        //~ $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
        $connection = new mysqli('sql303.260mb.com', 'pacus_6818312', 'des2mree', 'pacus_6818312_vitaminer');
        if ($connection->connect_error) die($connection->connect_error);
        //~ mysql_select_db($db_database) or die("No puedo seleccionar la BD: " . mysql_error());
    }

/*EOF*/
