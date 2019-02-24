<?
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
if($_GET["filter"]){
	$where = ' WHERE ';
	if(isset($_GET["filter"][0])){
		$id = $_GET["filter"][0];
		$where .= " id = $id ";
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

$sql = "SELECT * FROM carti 
		$where $order
		LIMIT $offset,$rowsperpage"; 
$sqlall = "SELECT * FROM carti $where";
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
		"Titlu"=> $row['titlu'],
		"Autor"=> $lista_autori[$row['id_autor']],
		"Exemplare"=> $row['nr_exemplare'],
		"Exemplare disponibile"=> $row['nr_exemplare_disp']
	) ;
	if($rang[$_SESSION['rang']] == 'Bibliotecar'){
		$row1['Imprumuta'] = '<a class="btn" href="../imprumuturi/add?carte='.$row['id'].'">Imprumuta</a>';
		$row1['Edit'] = '<a class="btn" href="../carti/edit&id='.$row['id'].'">Editeaza</a>';
		$row1['Sterge'] = '<a class="btn confirm sterge" data-load="../carti/list&stergeid='.$row['id'].'">Sterge</a>';
	}
 array_push($array_rows,$row1);
}

$newdata = array(
	'total_rows'=>$total_nums, 
	'headers' => array("ID", "Titlu" ,"Autor", "Exemplare", "Exemplare disponibile"), 
	'rows'=>$array_rows
);

if($rang[$_SESSION['rang']] == 'Bibliotecar'){
	array_push($newdata['headers'],"Imprumuta");
	array_push($newdata['headers'],"Edit");
	array_push($newdata['headers'],"Sterge");
}else{
	array_push($newdata['headers'],"B");
	array_push($newdata['headers'],"I");
	array_push($newdata['headers'],"B");
}

echo json_encode($newdata);
?>