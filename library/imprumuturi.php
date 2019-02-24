<?php include('header.php'); ?>
<!-- jquery.datePicker.js -->
<link rel="stylesheet" href="<?echo $root;?>css/jquery-ui-smoothness.css">
<script src="<?echo $root;?>js/jquery-ui-date.js"></script>

<!-- jquery.tablesorter.js -->
<link href="<?echo $root;?>css/theme.black-ice.css" rel="stylesheet">
<link href="<?echo $root;?>css/jquery.tablesorter.pager.css" rel="stylesheet">

<script src="<?echo $root;?>js/jquery.tablesorter.js"></script>
<script src="<?echo $root;?>js/jquery.tablesorter.widgets.js"></script>
<script src="<?echo $root;?>js/jquery.tablesorter.pager.js"></script>

<script id="js">
$(function(){

// Initialize tablesorter
// ***********************
$("table")
	.tablesorter({
		theme: 'blackice',
		widthFixed: true,
		sortLocaleCompare: true, // needed for accented characters in the data
		sortList: [ [0,1] ],
		widgets: ['zebra', 'filter'],
		
	 widgetOptions : {

      // extra css class applied to the table row containing the filters & the inputs within that row
      filter_cssFilter   : '',

      // If there are child rows in the table (rows with class name from "cssChildRow" option)
      // and this option is true and a match is found anywhere in the child row, then it will make that row
      // visible; default is false
      filter_childRows   : false,

      // if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
      // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
      filter_hideFilters : false,

      // Set this option to false to make the searches case sensitive
      filter_ignoreCase  : true,

      // jQuery selector string of an element used to reset the filters
      filter_reset : '.reset',

      // Use the $.tablesorter.storage utility to save the most recent filters
      filter_saveFilters : false,

      // Delay in milliseconds before the filter widget starts searching; This option prevents searching for
      // every character while typing and should make searching large tables faster.
      filter_searchDelay : 300,

      // Set this option to true to use the filter to find text from the start of the column
      // So typing in "a" will find "albert" but not "frank", both have a's; default is false
      filter_startsWith  : false,

      // if false, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
      // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
      filter_hideFilters : false,

      // Add select box to 4th column (zero-based index)
      // each option has an associated function that returns a boolean
      // function variables:
      // e = exact text from cell
      // n = normalized value returned by the column parser
      // f = search filter input value
      // i = column index
      filter_functions : {

        // Add select menu to this column
        // set the column value to true, and/or add "filter-select" class name to header
        // 3 : true

      }

    },
		
		
		// *** SORT OPTIONS ***
		// These are detected by default,
		// but you can change or disable them
		// these can also be set using data-attributes or class names
		headers: {
			// set "sorter : false" (no quotes) to disable the column
			0: {
				sorter: "digit"		
			},
			1: {
				sorter: "text"
			},
			2: {
				sorter: "text"
			},
			3: {
				sorter: "text"
			},
			4: {
				sorter: false,
				filter: false
			},
			5: {
				sorter: "date"
			},
			6: {
				sorter: "date"
			},
			7: {
				sorter: false,
				filter: false
			},
			8: {
				sorter: false,
				filter: false
			}
		}

	})

	// initialize the pager plugin
	// ****************************
	.tablesorterPager({

		// **********************************
		//  Description of ALL pager options
		// ********************************** 

		// target the pager markup - see the HTML block below
		container: $(".pager"),

		// use this format: "http:/mydatabase.com?page={page}&size={size}&{sortList:col}"
		// where {page} is replaced by the page number (or use {page+1} to get a one-based index),
		// {size} is replaced by the number of records to show,
		// {sortList:col} adds the sortList to the url into a "col" array, and {filterList:fcol} adds
		// the filterList to the url into an "fcol" array.
		// So a sortList = [[2,0],[3,0]] becomes "&col[2]=0&col[3]=0" in the url
		// and a filterList = [[2,Blue],[3,13]] becomes "&fcol[2]=Blue&fcol[3]=13" in the url
		ajaxUrl : '../ajax/get-imprumuturi.php?page={page}&size={size}&{filterList:filter}&{sortList:column}',

		// modify the url after all processing has been applied
		/*
		customAjaxUrl: function(table, url) {
				// manipulate the url string as you desire
				// url += '&cPage=' + window.location.pathname;
				// trigger my custom event
				$(table).trigger('changingUrl', url);
				// send the server the current page
				return url;
		}, 
		*/
		
		// add more ajax settings here
		// see http://api.jquery.com/jQuery.ajax/#jQuery-ajax-settings
		ajaxObject: {
			dataType: 'json'
		},

		// process ajax so that the following information is returned:
		// [ total_rows (number), rows (array of arrays), headers (array; optional) ]
		// example:
		// [
		//   100,  // total rows
		//   [
		//     [ "row1cell1", "row1cell2", ... "row1cellN" ],
		//     [ "row2cell1", "row2cell2", ... "row2cellN" ],
		//     ...
		//     [ "rowNcell1", "rowNcell2", ... "rowNcellN" ]
		//   ],
		//   [ "header1", "header2", ... "headerN" ] // optional
		// ]
		// OR
		// return [ total_rows, $rows (jQuery object; optional), headers (array; optional) ]
		ajaxProcessing: function(data){
			if (data && data.hasOwnProperty('rows')) {
				var r, row, c, d = data.rows,
				// total number of rows (required)
				total = data.total_rows,
				// array of header names (optional)
				headers = data.headers,
				// all rows: array of arrays; each internal array has the table cell data for that row
				rows = [],
				// len should match pager set size (c.size)
				len = d.length;
				// this will depend on how the json is set up - see City0.json
				// rows
				for ( r=0; r < len; r++ ) {
					row = []; // new row array
					// cells
					for ( c in d[r] ) {
						if (typeof(c) === "string") {
							row.push(d[r][c]); // add each table cell data to row array
						}
					}
					rows.push(row); // add new row array to rows array
				}
				// in version 2.10, you can optionally return $(rows) a set of table rows within a jQuery object
				return [ total, rows, headers ];
			}
		},

		// output string - default is '{page}/{totalPages}'; possible variables: {page}, {totalPages}, {startRow}, {endRow} and {totalRows}
		output: '{startRow} to {endRow} ({totalRows})',

		// apply disabled classname to the pager arrows when the rows at either extreme is visible - default is true
		updateArrows: true,

		// starting page of the pager (zero based index)
		page: 0,

		// Number of visible rows - default is 10
		size: 20,

		// if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
		// table row set to a height to compensate; default is false
		fixedHeight: false,

		// remove rows from the table to speed up the sort of large tables.
		// setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
		removeRows: false,

		// css class names of pager arrows
		cssNext        : '.next',  // next page arrow
		cssPrev        : '.prev',  // previous page arrow
		cssFirst       : '.first', // go to first page arrow
		cssLast        : '.last',  // go to last page arrow
		cssPageDisplay : '.pagedisplay', // location of where the "output" is displayed
		cssPageSize    : '.pagesize', // page size selector - select dropdown that sets the "size" option
		cssErrorRow    : 'tablesorter-errorRow', // error information row

		// class added to arrows when at the extremes (i.e. prev/first arrows are "disabled" when on the first page)
		cssDisabled    : 'disabled' // Note there is no period "." in front of this class name

	});
});
</script>

<script>
$(function() {
	$( "#from" ).datepicker({
			//minDate: 0,
			//defaultDate: "+0d",
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			onClose: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
	$( "#to" ).datepicker({
			defaultDate: "+2w",
			changeMonth: true,
			numberOfMonths: 1,
			dateFormat: "yy-mm-dd",
			onClose: function( selectedDate ) {			
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
				$(".c").show();
				$(".camera").click();
			}
		});
});
</script>
<?
echo '<div class="span10">';
if(isset($pagini[1])){
	$tip = $pagini[1];
	$foo = new Smart();
	$foo->table = 'imprumuturi';
	if(isset($_POST['submit'])){ // add/edit
		$array = array(
			'id_carte' => $_POST['id_carte'],
			'id_cititor' =>$_POST['id_cititor'],
			'id_bibliotecar' => $_SESSION['id_utilizator'],
			'data_imprumut' => $_POST['data_imprumut'],
			'data_returnare' => $_POST['data_returnare'],
			'nr_exemplare' => $_POST['nr_exemplare']
		);
		$foo->arr = $array;
		if(isset($_GET['id']) && $tip == "edit"){ //editare
			$id = $_GET['id'];
			$foo->where = "WHERE id = '$id'";
			echo $foo->edit();
		}	
		elseif($tip == "add"){//insert
			echo $foo->insert();
			$id = mysql_insert_id();
		}					
	}
	if($tip == "list"){//lista
		if($rang[$_SESSION['rang']] == 'Abonat'){
			$foo->arr = array("id_cititor" => $_SESSION['id_utilizator']);
		}
		$rows = $foo->select();
	}
	elseif(isset($_GET['id'])){//get ptr edit
		$id = $_GET['id'];
		$foo->arr = array('id' => $id);
		$row = reset($foo->select());
	}
	
	switch(true){
		case ($tip == "add" OR $tip == "edit"):// editare;
			$readonly = '';
			$disabled = '';
			if($tip == "edit"){ $readonly = 'readonly'; $disabled = 'disabled';}
?>
<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	<div class="row-fluid">
		<div class="span4">
			<label for="carte">Carte</label>
			<select <?echo $disabled;?> name="id_carte">
				<option value="0">Alege carte</option>
				<?php
					if($tip == "add"){
						$carte = 0;
						if(isset($_GET['carte'])){
							$carte = $_GET['carte'];
						}
						foreach($lista_carti as $key=>$value){
							$selected = '';
							if($carte == $key){
								$selected = 'selected="selected"';
							}
							echo '<option '.$selected.' value="'.$key.'">'.$value.' , '.$lista_autor_carte[$key].'</option>';
						}
						
					}
					elseif($tip == "edit"){
						foreach($lista_carti as $key=>$value){
							$selected = '';
							if($row['id_carte'] == $key){
								$selected = 'selected="selected"';
							}
							echo '<option '.$selected.' value="'.$key.'">'.$value.' , '.$lista_autor_carte[$key].'</option>';
						}
					}
				?>
			</select>
			
			<select <?echo $disabled;?> name="id_cititor">
				<option value="0">Alege cititor</option>
				<?php
					foreach($lista_abonati as $key=>$value){
						$selected = '';
						if($row['id_cititor'] == $key){
							$selected = 'selected="selected"';
						}
						echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
					}
				?>
			</select>	
			<label for="exemplare">Numar exemplare</label>
			<input class="input-xlarge" value="<?php echo $row['nr_exemplare'];?>" name="nr_exemplare" type="text" required placeholder="numar exemplare"/>														
							
			<label for="status">Status imprumut</label>
			<select name="status">
				<?php
					foreach($status_imprumut as $key=>$value){
						$selected = '';
						if($row['status'] == $key){
							$selected = 'selected="selected"';
						}
						echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
					}
				?>
			</select>
		
			<label for="data_imprumut">Din</label>
			<input id="from" class="input-xlarge" value="<?php echo $row['data_imprumut'];?>" name="data_imprumut" type="text" required/>					
		
			<label for="data_returnare">Pana</label>
			<input id="to" class="input-xlarge" value="<?php echo $row['data_returnare'];?>" name="data_returnare" type="text" required/>					
		

		
		</div>					
	</div>
	<div class="row-fluid">			
		<div class="span8">
			<div class="form-actions">
				<button class="btn" type="submit" name="submit">Save</button>
			</div>
		</div>			
	</div>			
</form>
<?php 
break;
case ($tip == "list")://lista 
	echo '<div class="row-fluid">	';
?>
<table class="tablesorter">
	<thead>
		<tr>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th> 
			<th>6</th>
			<th>7</th>
			<th>8</th>
			<th>9</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
			<th>6</th>
			<th>7</th>
			<th>8</th>
			<th>9</th>
		</tr>
		<tr>
			<td class="pager" colspan="9">
				<img src="../images/first.png" class="first" alt="First" />
				<img src="../images/prev.png" class="prev" alt="Prev" />
				<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
				<img src="../images/next.png" class="next" alt="Next" />
				<img src="../images/last.png" class="last" alt="Last" />
				<select class="pagesize">
					<option value="1">1</option>
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="25">25</option>
				</select>
			</td>
		</tr>
	</tfoot>
	<tbody>
	</tbody>
</table>
<?
			echo '</div>';
		break;
	}
}	echo '</div>';

include('footer.php');
?>
 