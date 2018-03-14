<?php
if ( isset( $_POST['id_turma'] ) ) {
	setcookie( 'id_turma', $_POST['id_turma'] );
}

if ( file_exists( 'conn.php' ) ) {
	require_once 'conn.php';
} else {
	require_once '../conn.php';
}
$day = date( 'w' ) - 1;

$turmas = $conn->query( "SELECT idturma, descricao FROM turmas ORDER BY descricao;" );
$selectedTurma = 0;
if(!empty($_COOKIE['id_turma'])) {
    $selectedTurma = $_COOKIE['id_turma'];
}

if(isset($_POST['id_turma'])) {
    $selectedTurma = $_POST['id_turma'];
}
?>

<div class="row" style="margin-top: 1em;">
    <form class="col s12" method="post">
        <div class="row">
            <div class="input-field col s12 m6">
                <select name="id_turma" id="turma">
					<?php
					while ( $row = $turmas->fetch_assoc() ) {
						echo '<option value="' . $row['idturma'] . '" ';
						if($selectedTurma == $row['idturma']) {
						    echo 'selected="selected"';
                        }
						echo '>' . $row['descricao'] . '</option>';
					}
					?>
                </select>
                <label for="turma">Turma</label>
            </div>

            <div class="input-field col s12 m5">
                <select name="dia" id="dia">
                    <option value="0" <?php if ( $day == 0 ) {
						echo 'selected="selected"';
					} ?>>Segunda-feira
                    </option>
                    <option value="1" <?php if ( $day == 1 ) {
						echo 'selected="selected"';
					} ?>>Terça-feira
                    </option>
                    <option value="2" <?php if ( $day == 2 ) {
						echo 'selected="selected"';
					} ?>>Quarta-feira
                    </option>
                    <option value="3" <?php if ( $day == 3 ) {
						echo 'selected="selected"';
					} ?>>Quinta-feira
                    </option>
                    <option value="4" <?php if ( $day == 4 ) {
						echo 'selected="selected"';
					} ?>>Sexta-feira
                    </option>
                    <option value="5" <?php if ( $day == 5 ) {
						echo 'selected="selected"';
					} ?>>Sábado
                    </option>
                </select>
                <label for="dia">Dia da Semana</label>
            </div>

            <div class="input-field col s12 m1">
                <button class="waves-effect waves-light btn green darken-4" type="submit"  style="width: 100%;">
                    <i class="material-icons">check</i>
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    jQuery(document).ready(function () {
        jQuery('select').material_select();
    });
</script>


<?php

if ( isset( $_POST['id_turma'] ) || ! empty( $_COOKIE['id_turma'] ) ) {
	$dia     = ( isset( $_POST['dia'] ) ) ? $_POST['dia'] : $day;
	$idTurma = ( isset( $_POST['id_turma'] ) ) ? $_POST['id_turma'] : $idTurma = $_COOKIE['id_turma'];


	$dailyQuery = "SELECT H.periodo PERIODO, H.descricao AULA, " .
	              "H.inicio INICIO, H.fim FIM, D.sigla MATERIA, P.nome PROFESSOR " .
	              "FROM ifsp_horarios.horarios_disciplinas HD " .
	              "INNER JOIN ifsp_horarios.disciplinas D ON (HD.iddisciplina=D.iddisciplina) " .
	              "INNER JOIN ifsp_horarios.horarios H ON (HD.idhorario=H.idhorario) " .
	              "INNER JOIN ifsp_horarios.turmas T ON (HD.idturma=T.idturma) " .
	              "INNER JOIN ifsp_horarios.professores P ON (HD.idprofessor=P.idprofessor) " .
	              "WHERE (HD.idturma = " . $idTurma . ") AND (HD.diasemana = " . $dia . " )" .
	              "ORDER BY HD.diasemana, PERIODO, INICIO ";

	$result3 = $conn->query( $dailyQuery );


	if ( mysqli_num_rows( $result3 ) > 0 ) {
	    $periodo = "";
		while ( $rows = mysqli_fetch_array( $result3, MYSQLI_ASSOC ) ) {
		    if($rows['PERIODO'] != $periodo) {
		        if($periodo != "") {
			        tableClose();
                }
		        echo '<h5>' . $rows['PERIODO'] . '</h5>';
		        tableOpen();
			    $periodo = $rows['PERIODO'];
            }
			echo "<tr>";

            echo "<td align='center'>" . $rows['AULA'] . "</td>";
            echo "<td align='center'>" . $rows['INICIO'] . "</td>";
            echo "<td align='center'>" . $rows['FIM'] . "</td>";
            echo "<td align='center'>" . $rows['MATERIA'] . "</td>";
            echo "<td align='center'>" . $rows['PROFESSOR'] . "</td>";

			echo "</tr>";
		}

	}


}

function tableOpen() {
	echo '<table class="striped">';
	echo '<thead style="text-transform: uppercase; text-align: center"><tr><th>Aula</th><th>Início</th><th>Fim</th><th>Cód.</th><th>Profesor</th></tr></thead><tbody>';
}

function tableClose() {
	echo '</tbody></table>';
}
?>
