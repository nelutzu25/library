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
	if(isset($_GET["filter"][1])){
		$nume = $_GET["filter"][1];
		$where .= " nume LIKE '%$nume%' ";
	}	
	if(isset($_GET["filter"][2])){
		$prenume = $_GET["filter"][2];
		$where .= " prenume LIKE '%$prenume%' ";
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
		$nume = $_GET["column"][1];
		if($nume == 1)
			$order .= " nume ASC ";
		if($nume == 0)
			$order .= " nume DESC ";
	}	
	if(isset($_GET["column"][2])){
		$prenume = $_GET["column"][2];
		if($prenume == 1)
			$order .= " prenume ASC ";
		if($prenume == 0)
			$order .= " prenume DESC ";
	}
}
$offset = $pagenum  * $rowsperpage; //WHERE THE RESULTS START FROM

$sql = "SELECT * FROM autori 
		$where $order
		LIMIT $offset,$rowsperpage"; 
$sqlall = "SELECT * FROM autori $where";
//echo $sql;
//echo $sqlall;

$q = mysql_query($sql);
$page_nums = mysql_num_rows($q); //NUMBER OF RESULTS FOR THE PAGE
$total_q = mysql_query($sqlall); //FOR THE ALL RESULTS
$total_nums = mysql_num_rows($total_q); //TOTAL NUMBER OF RESULTS

$array_rows = array();
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
 $row1 = array("ID"=> $row['id'],
		"Nume"=> $row['nume'],
		"Prenume"=> $row['prenume'],
		"Edit"=> '<a class="btn" href="../autori/edit&id='.$row['id'].'">Editeaza</a>',
		"Sterge"=> '<a class="btn confirm sterge" data-load="../autori/list&stergeid='.$row['id'].'">Sterge</a>') ;
 array_push($array_rows,$row1);
}

$newdata = array(
	'total_rows'=>$total_nums, 
	'headers' => array("ID", "Nume" ,"Prenume","Edit", "Sterge"), 
	'rows'=>$array_rows
);

echo json_encode($newdata);
?>