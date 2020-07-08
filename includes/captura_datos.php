<?php

    require_once('login.php');

    define("VACIO", "nombre_vacio");
    define("REPE", "nombre_repetido");
    define("EXISTE", "nombre_ya_existe");

    $nombre = "";
    $nombre_msg = "";
    $minimo = "";
    $recomendado = "";
    $beneficios = "";
    $alimentos = "";
    $notas = "";
    $radio = "";

    function vitaminer_captura_datos() {

        global $nombre, $nombre_msg, $minimo, $recomendado;
        global $beneficios, $alimentos, $notas, $radio;

        $nombre_msg = "";

        if($_POST['vitaminer_hidden'] == 'Y') {
            $resultado = lee_comprueba_datos();
            if ($resultado === true) {
                //~ print('Correcto');
                vitaminer_graba_datos();
            } elseif ($resultado == VACIO) {
                $nombre_msg = "_HAY QUE RELLENAR EL NOMBRE_";
                vitaminer_pide_datos();
            } elseif ($resultado == REPE) {
                if ($radio === "sobre") {
                    print('sobre-escribir');
                } elseif ($radio === "cancela") {
                    print("<br /><br /><h1>Cancelado</h1>");
                } else {
                    vitaminer_pide_datos(EXISTE);
                }
            }
        } else {
            vitaminer_pide_datos();
        }
    }

    function vitaminer_pide_datos($existe = false) {

        global $nombre, $nombre_msg, $minimo, $recomendado;
        global $beneficios, $alimentos, $notas;

        print("<div class='wrap'>");
        print('<h2>Introducción de datos de vitaminas y minerales</h2>');
        print('<form name="vitaminer_form" method="post" action=' . $_SERVER['REQUEST_URI'] . '>');
        print('<input type="hidden" name="vitaminer_hidden" value="Y">');
        print('Vitamina o mineral: <input type="text" name="nombre" value="'.$nombre.'" size="20"><span style="color:#ff0000">'.$nombre_msg.'</span><br />');
        print('Cantidad mínima: <input type="text" name="minimo" value="'.$minimo.'" size="20"><br />');
        print('Cantidad recomendada: <input type="text" name="recomendado" value="'.$recomendado.'" size="20"><br />');
        print('Beneficios: <input type="text" name="beneficios" value="'.$beneficios.'" size="80"><br />');
        print('Alimentos: <input type="text" name="alimentos" value="'.$alimentos.'" size="80"><br />');
        print('Notas: <input type="text" name="notas"  value="'.$notas.'"size="80"><br />');
        print('<br />');
        if ($existe === false) {
            print('<input type="submit" value="Grabar" style="color:#ff0000">');
        } else {
            print('Ya existe un registro con ese nombre, elija opción:<br />');
            print('<input type="radio" id="sobre" name="sobre_cancela" value="sobre">');
            print('<label for="sobre">Sobre-escribir</label><br />');
            print('<input type="radio" id="cancela" name="sobre_cancela" value="cancela">');
            print('<label for="cancela">Cancelar</label><br />');
            print('<br /><input type="submit" value="Aceptar" style="color:#ff0000">');
        }
        print('</form>');
        print('</div>');
    }

    function lee_comprueba_datos() {

        global $nombre, $nombre_msg, $minimo, $recomendado;
        global $beneficios, $alimentos, $notas, $radio;

        $nombre = $_POST['nombre'];
        $minimo = $_POST['minimo'];
        $beneficios = $_POST['beneficios'];
        $recomendado = $_POST['recomendado'];
        $alimentos = $_POST['alimentos'];
        $notas = $_POST['notas'];
        $radio = $_POST['sobre_cancela'];

        if (!$nombre) return VACIO;
        if (existe_nombre($nombre)) return REPE;
        return true;
    }

    function existe_nombre($nombre) {
        global $nombre;

        $conn = vitaminer_db('abrir');
        $res = $conn->query('SELECT * FROM elemento WHERE nombre = '.$nombre);
        if ($res->num_rows > 0) return true;
        return false;
    }

    function vitaminer_graba_datos() {
        global $nombre, $minimo, $recomendado;
        global $beneficios, $alimentos, $notas;

        $conn = vitaminer_db('abrir');
        $sen = $conn->prepare("INSERT INTO elemento VALUES (?, ?, ?, ?)");
        $sen->bind_param('ssssss', $nom, $min, $rec, $benef, $alim, $not);
        $nom = $nombre;
        $min = $minimo;
        $rec = $recomendado;
        $benef = $beneficios;
        $alim = $alimentos;
        $not = $notas;
        $sen->execute();
        $sen->close();
        vitaminer_db('cerrar');
    }

    function vitaminer_db($accion) {

        static $conectado;
        static $connection;
        global $nombre, $minimo, $recomendado;
        global $beneficios, $alimentos, $notas;

        if ($accion == 'abrir') {
            if ($conectado === true) return $connection;
            $connection = new mysqli('sql303.260mb.com', 'pacus_6818312', 'des2mree', 'pacus_6818312_vitaminer');
            if ($connection->connect_error) die('Falló la conexión a MySQL: '.$connection->connect_error);
            $conectado = true;
            return $connection;
        } else {
            $connection->close();
        }
    }

//http://antovar.260mb.com/wp1/wp-admin/reauth=1

/*EOF*/
