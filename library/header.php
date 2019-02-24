<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Biblioteca</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="<?echo $root;?>css/jquery-ui.custom.min.css" rel="stylesheet">
		<link href="<?echo $root;?>css/bootstrap.css" rel="stylesheet">
		<script src="<?echo $root;?>js/jquery.min.js"></script>
	</head>

	<body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="<?echo $root;?>">Biblioteca</a>
		  <?if(isset($_SESSION['logat']) && $_SESSION['logat']==true){?>
			<a  href="<?echo $root;?>contul-meu"><?echo $_SESSION['username'];?>
				<img width="20px" height="20px" id="preview" src="../uploads/<?php echo getFile('uploads/',$_SESSION['id_utilizator']);?>" alt="poza profil" /><br/>
				<?echo $rang[$_SESSION['rang']];?>
			</a>
		  <?}?>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
			<?php if(isset($_SESSION['logat']) && $_SESSION['logat'] == true){ ?>
            <? if($rang[$_SESSION['rang']] == 'Administrator'){?>
			  <li class="nav-header">Useri</li>
              <li><a href="<?echo $root;?>useri/list">Lista</a></li>
			  <li><a href="<?echo $root;?>useri/add">Adauga</a></li>
			<?}?>
			<? if($rang[$_SESSION['rang']] == 'Bibliotecar'){?>
			  <li class="nav-header">Carti</li>
              <li><a href="<?echo $root;?>carti/list">Lista</a></li>
			  <li><a href="<?echo $root;?>carti/add">Adauga</a></li>
			  <li class="nav-header">Autori</li>
              <li><a href="<?echo $root;?>autori/list">Lista</a></li>
			  <li><a href="<?echo $root;?>autori/add">Adauga</a></li>
			  <li class="nav-header">Imprumuturi</li>
              <li><a href="<?echo $root;?>imprumuturi/list">Lista</a></li>
              <li><a href="<?echo $root;?>imprumuturi/add">Imprumuta</a></li>
			 <?}?>
			 <? if($rang[$_SESSION['rang']] == 'Abonat'){?>
			 <li class="nav-header"><a href="<?echo $root;?>carti/list">Vezi carti</a></li>
			 <li class="nav-header"><a href="<?echo $root;?>imprumuturi/list">Imprumuturile mele</a></li>
			 <?}?>
		  	    
			  <li class="nav-header"><a href="<?echo $root;?>contul-meu">contul meu</a></li>
			  <li class="nav-header"><a href="<?echo $root;?>logout">logout</a></li>
			  <?php } else {?>
			  <li class="nav-header"><a href="<?echo $root;?>login">login</a></li>
			  <li class="nav-header"><a href="<?echo $root;?>register">register</a></li>
			  <?php } ?>
            </ul>
          </div><!--/.well -->
		  <h2><?echo $pagini[0];?></h2>
        </div><!--/span-->	