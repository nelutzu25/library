<?php
ob_start();
session_start();
require_once('includes/functions.php');
if(isset($_GET['pagina'])){
	$pagini = explode("/",$_GET['pagina']);
}
$simple = array("useri","carti","login","logout","register","home","imprumuturi","autori");
$pag_admin = array("useri","login","logout","register","home");
$pag_bibliotecar = array("carti","login","logout","register","home","imprumuturi","autori");
$pag_abonat = array("carti","login","logout","register","home","imprumuturi");

$imprumuta = explode("-",$pagini[0]);
$pagein = "home.php";
if(isset($pagini)){

	switch(true){
		case(in_array($pagini[0],$simple)):
			$pagein = $pagini[0].'.php';
			if (isset($_SESSION['logat']) && $_SESSION['logat']==true ) {
				if($rang[$_SESSION['rang']] == 'Administrator' && !(in_array($pagini[0],$pag_admin)) )
					$pagein = "home.php";
				if($rang[$_SESSION['rang']] == 'Bibliotecar' && !(in_array($pagini[0],$pag_bibliotecar)) )
					$pagein = "home.php";
				if($rang[$_SESSION['rang']] == 'Abonat' && !(in_array($pagini[0],$pag_abonat)) )
					$pagein = "home.php";
			}
		break;
		case($pagini[0] == 'contul-meu'):
			$pagein = "contul-meu.php";
			$id = $_SESSION['id_utilizator'];
			$result = mysql_query("SELECT * FROM useri WHERE id='$id' LIMIT 1");
			$cont = mysql_fetch_array($result); 	
		break;
		default:	
			$pagein = "home.php";
		break;
	}

}

if($pagein != 'register.php')
	if ( !isset($_SESSION['logat']) || $_SESSION['logat']!=true ) 
		$pagein = "login.php";


include($pagein);
?>