<?php
session_start();
require_once('../includes/functions.php'); 
//print_r($_GET);

//PAGE NUMBER, RESULTS PER PAGE, AND OFFSET OF THE RESULTS
if($_GET["page"]){
    $pagenum = $_GET["page"]; 
}
if($_GET["size"]){
	$rowsperpage = $_GET["size"]; //MAXIMUM RESULTS PER PAGE
}
$where = '';
//print_r($_SESSION);
if($_GET["filter"] OR $rang[$_SESSION['rang']] == 'Abonat'){
	$where = ' WHERE ';
	if(isset($_GET["filter"][0])){
		$id = $_GET["filter"][0];
		$where .= " id = $id ";
	}
	
	if($rang[$_SESSION['rang']] == 'Abonat'){
		$ab = $_SESSION['id_utilizator'];
		$where = " WHERE id_cititor=$ab ";
		
	}
}

$order = '';
if($_GET["column"]){
	$order = ' ORDER BY ';
	if(isset($_GET["column"][0])){
		$id = $_GET["column"][0];
		if($id == 1)
			$order .= " id ASC ";
		if($id == 0)
			$order .= " id DESC ";
	}
	if(isset($_GET["column"][1])){
		$titlu = $_GET["column"][1];
		if($titlu == 1)
			$order .= " titlu ASC ";
		if($titlu == 0)
			$order .= " titlu DESC ";
	}
	if(isset($_GET["column"][3])){
		$ex = $_GET["column"][3];
		if($ex == 1)
			$order .= " nr_exemplare ASC ";
		if($ex == 0)
			$order .= " nr_exemplare DESC ";
	}
	if(isset($_GET["column"][4])){
		$ed = $_GET["column"][4];
		if($ed == 1)
			$order .= " nr_exemplare_disp ASC ";
		if($ed == 0)
			$order .= " nr_exemplare_disp DESC ";
	}
}
$offset = $pagenum  * $rowsperpage; //WHERE THE RESULTS START FROM

$sql = "SELECT * FROM imprumuturi 
		$where $order
		LIMIT $offset,$rowsperpage"; 
$sqlall = "SELECT * FROM imprumuturi $where";
//echo $sql;
//echo $sqlall;

$q = mysql_query($sql);
$page_nums = mysql_num_rows($q); //NUMBER OF RESULTS FOR THE PAGE
$total_q = mysql_query($sqlall); //FOR THE ALL RESULTS
$total_nums = mysql_num_rows($total_q); //TOTAL NUMBER OF RESULTS

$array_rows = array();
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
 $row1 = array(
		"ID"=> $row['id'],
		"Titlu"=> $lista_carti[$row['id_carte']],
		"Autor"=> $lista_autor_carte[$row['id_carte']],
		"Cititor"=> $lista_useri[$row['id_cititor']],
		"Exemplare"=> $row['nr_exemplare'],
		"Data imprumut"=> $row['data_imprumut'],
		"Data returnare"=> $row['data_returnare'],
		"Edit"=> '<a class="btn" href="../imprumuturi/edit&id='.$row['id'].'">Editeaza</a>',
		"Sterge"=> '<a class="btn confirm sterge" data-load="../imprumuturi/list&stergeid='.$row['id'].'">Sterge</a>'
		) ;
 array_push($array_rows,$row1);
}

$newdata = array(
	'total_rows'=>$total_nums, 
	'headers' => array("ID", "Titlu" ,"Autor", "Cititor","Exemplare", "Data imprumut","Data returnare" ,"Edit", "Sterge"), 
	'rows'=>$array_rows
);

echo json_encode($newdata);
?>