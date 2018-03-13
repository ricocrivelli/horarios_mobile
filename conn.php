<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 27/02/2018
 * Time: 10:16
 */
$conn = new mysqli('localhost', 'root', '', 'ifsp_horarios')
or die ('Cannot connect to db');
mysqli_set_charset($conn,"utf8");

const DIAS = array(
    "SEGUNDA",
    "TERÇA",
    "QUARTA",
    "QUINTA",
    "SEXTA",
    "SÁBADO");