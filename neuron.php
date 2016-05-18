<?php
  include ("permission_check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	
 require_once('class/class.temporary_neuronname.php');
 require_once('class/class.type.php');
		
$temporary = new temporary_neuronname();
$type_1 = new type($class_type);		
	
// Select AND / OR:
if ($_REQUEST['and_or'])
{
	$and_or = $_REQUEST['and_or'];
	$_SESSION['and_or'] = $and_or;
	
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary ->setName_table($name_temporary_table);
	$temporary_search = 1;
}

// Resume searching
if ($_REQUEST['resume_searching_tab'])
{
	$resume_searching = $_SESSION['resume_searching'];	
	$name_temporary_table = $resume_searching;
	$_SESSION['name_temporary_table'] = $name_temporary_table;
	$temporary ->setName_table($name_temporary_table);
}

// Creates the temporary table for the search 
if ($_REQUEST['searching'])
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
	
	$name_temporary_table ='search1_'.$ip_address."__".$time_t;
	$_SESSION['name_temporary_table'] = $name_temporary_table;
	
	$temporary ->setName_table($name_temporary_table);
	
	$temporary -> create_temp_table ($name_temporary_table);
	$temporary -> insert_temporary('C', 'CA3 (e)23223p-CA2_0101-CA1_0101 Pyramidal');
	
	$temporary_search=0;
	
	$and_or = 'AND';
	$_SESSION['and_or'] = $and_or;		
}

if($_REQUEST['new'])
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$ip_address = str_replace('.', '_', $ip_address);
	$time_t = time();
		
	$name_temporary_table ='search1_'.$ip_address."__".$time_t;
	$_SESSION['name_temporary_table'] = $name_temporary_table;
		
	$temporary ->setName_table($name_temporary_table);

	$temporary -> create_temp_table ($name_temporary_table);
	$temporary -> insert_temporary($_GET["first_neuron"], $_GET["name_neuron"]);
	$temporary_search=0;
		
	$and_or = 'AND';
	$_SESSION['and_or'] = $and_or;
}

// update the letter in the temporary table: 
$letter = $_REQUEST['letter'];
if ($letter)
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$id_update = $_REQUEST['id'];
	/*----------------------------------new-------------------------------*/
					// retrieve ALL authors from table AUTHOR:
					$type_1 -> retrive_name();
				    $type_1->retrive_nickname();
					$n_neuron_total_name = $type_1 -> getName_neuron();
					$n_neuron_total_nickname = $type_1 -> getNickname_neuron();
					// keep only the authors that have the first letter = $letter_t:
					
					$n_neuron = 0;
					$name_neuron = NULL;
					
					
					for ($i1=0; $i1<$n_neuron_total_name; $i1++)
					{
						$name_neuron1 = $type_1 -> getName_neuron_array($i1);		
						if ($letter == 'all')
						{
							$name_neuron[$n_neuron] = $name_neuron1;
							
							$n_neuron = $n_neuron + 1;	
							
						}
						else if ($name_neuron1[0] == $letter)
							{
								$name_neuron[$n_neuron] = $name_neuron1;
					
								$n_neuron = $n_neuron + 1;
							}
										
					
			
                            						
					}
			sort($name_neuron);
			$n_count=$n_neuron;
					
			// new method
		$name_neuronx= NULL;
	for ($i1=0; $i1<$n_neuron_total_nickname; $i1++)
					{
					$name_neuron4 = $type_1 -> getNickname_neuron_array($i1);
			
						if ($letter == 'all')
						{
							$name_neuronx[$n_neuron] = $name_neuron4;
							
							$n_neuron = $n_neuron + 1;						
						}
						else if ($name_neuron4[0] == $letter)
							{
			
							    $name_neuronx[$n_neuron] = $name_neuron4;
								$n_neuron = $n_neuron + 1;
							}
										
			
                       							
					}			
					
					//natcasesort($name_neuronx); 
					


/*----------------------------------------------------------------------- DONE*/
	$temporary ->setName_table($name_temporary_table);
	$temporary -> update_temporary($letter, $name_neuron[0], 1, $id_update);
	
	$temporary_search=0;
	
	$and_or = $_SESSION['and_or'];
}

$neuron5 = $_REQUEST['type'];
if ($neuron5)
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$id_update = $_REQUEST['id'];
	
	$temporary ->setName_table($name_temporary_table);
	$temporary -> update_temporary(NULL, $neuron5, 2, $id_update);
	
	$temporary_search=1;
	$and_or = $_SESSION['and_or'];
}

// ADD a new line for a new Author: --------------------------------------------------------------------
if ($_REQUEST['plus'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary ->setName_table($name_temporary_table);

	$temporary -> insert_temporary('C', 'CA3 (e)23223p-CA2_0101-CA1_0101 PyramidalCA3 Giant');

	$temporary_search=0;	
	$and_or = $_SESSION['and_or'];
}

// REMOVE line  -----------------------------------------------------------------------------------------
if ($_REQUEST['remove'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary ->setName_table($name_temporary_table);
	$id_temp = $_REQUEST['id'];

	$temporary -> remove($id_temp);

	$temporary_search=1;
	$and_or = $_SESSION['and_or'];
}

// Show result --------------------------------------------------------------------------------------------
if ($_REQUEST['see_result'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$temporary ->setName_table($name_temporary_table);
	$temporary_search=1;
	$and_or = $_SESSION['and_or'];
}
	if ($temporary_search == 1)
{
	$and_or = $_SESSION['and_or'];

	//$temporary -> retrieve_id();
	//$n_id = $temporary -> getN_id();
	
	if ($_REQUEST['see_result'])
	{
		$j3=0;
		//$pmid=array();
		
			
			//$type_1 -> retrive_by_id($$n_neuron_id[$i3]);
			//if(!in_array($type_1 -> getN_id(), $nid))
			//{
				$names[j3]= $type_1 -> getName_neuron_array();
				//$nicknames[$j3] = $type_1 -> getNickname();
				//$journal[$j3] = $article_1 -> getPublication();
				//$year[$j3] = $article_1 -> getYear();
				//$doi[$j3] = $article_1 -> getDoi();
		
			}
		// END $i3
		
		//remove duplicate articles
		//UNIQUE pmid
		
		
	}	
	
	
// Clear all ---------------------------------------------
if ($_REQUEST['clear_all'])
{
	$name_temporary_table = $_SESSION['name_temporary_table'];
	$query = "TRUNCATE $name_temporary_table";
	$rs = mysql_query($query);
	// Creates the temporary table:
	$temporary -> setName_table($name_temporary_table);	
	$temporary -> insert_temporary('C', 'CA3 (e)23223p-CA2_0101-CA1_0101 Pyramidal');
}
// -------------------------------------------------------
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
// Javascript function *****************************************************************************************************
function letter(link, id_1)
{
	var letter=link[link.selectedIndex].value;
	var id = id_1;
	
	var destination_page = "find_neuron_name.php";
	location.href = destination_page+"?letter="+letter+"&id="+id;
}

function neuron(link, id_1)
{
	var author=link[link.selectedIndex].value;
	var id = id_1;
	
	var destination_page = "find_neuron_name.php";
	location.href = destination_page+"?neuron="+neuron+"&id="+id;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include ("function/icon.html"); ?>

<title>Find Neuron Name/Synonym</title>

<script type="text/javascript" src="style/resolution.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<script src="DataTables-1.9.4/media/js/jquery.js" type="text/javascript"></script>
<script src="DataTables-1.9.4/media/js/jquery.dataTables.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="DataTables-1.9.4/media/css/demo_table_jui.css"/>
<link rel="stylesheet" type="text/css" href="DataTables-1.9.4/examples/examples_support/themes/smoothness/jquery-ui-1.8.4.custom.css"/>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	$('#tab_res').dataTable({
			"sPaginationType":"full_numbers",
			"bJQueryUI":true,
			"oLanguage": {
			      "sSearch": "Search for keywords inside the table:"
			    },
			"iDisplayLength": 25
		});
});
</script>
</head>

<body>

<!-- COPY IN ALL PAGES -->
<?php 
	include ("function/title.php");
	include ("function/menu_main.php");
?>	
	
<div class='title_area'>
	<font class="font1">Search by Neuron Name/Synonym</font>
</div>	


<div class="table_position_search_page">
<table width="95%" border="0" cellspacing="5" cellpadding="0" class='body_table'>
  <tr>
    <td width="80%">
		<!-- ****************  BODY **************** -->
		
		<br /><br />
		
		<table border="0" cellspacing="2" cellpadding="0" class='table_search'>
		<tr>
			<td align="center" width="10%">  </td>
			<td align="center" width="14%" class='table_neuron_page3'>Neuron Initial</td>
			<td align="center" width="50%" class='table_neuron_page3'>Name/Synonym</td>
			<td align="right" width="40%"> 
		
			
			</td>
		</tr>
		</table>


<table border="0" cellspacing="3" cellpadding="0" class='table_search'>
			<?php
				$temporary -> retrieve_id();
				$n_search = $temporary -> getN_id();
				//print($n_search);
				for ($i=0; $i<$n_search; $i++)
				{
					print ("<tr>
							<td align='center' width='18%'>  </td>
							<td align='center' width='20%' class='table_neuron_page1'>");
						
						$id = $temporary -> getID_array($i);
					
						print ("<select name='letter1' size='1' cols='20' class='select1' onChange=\"letter(this, $id)\">");
						
						$temporary -> retrieve_letter_from_id($id);
						$letter_t = $temporary -> getLetter();
						if ($letter_t)
						{
							if ($letter_t == 'all')
								$letter_t  = 'all';
								//$letter_t  = '--';
						
							print ("<OPTION VALUE='$letter_t'> $letter_t </OPTION>");					
							//print ("<OPTION VALUE=''> </OPTION>");
						}
						print ("
							<OPTION VALUE='A'> A </OPTION>			
							<OPTION VALUE='B'> B </OPTION>
							<OPTION VALUE='C'> C </OPTION>
							<OPTION VALUE='D'> D </OPTION>
							<OPTION VALUE='E'> E </OPTION>
							<OPTION VALUE='F'> F </OPTION>
							<OPTION VALUE='G'> G </OPTION>
							<OPTION VALUE='H'> H </OPTION>
							<OPTION VALUE='I'> I </OPTION>
							<OPTION VALUE='J'> J </OPTION>
							<OPTION VALUE='K'> K </OPTION>
							<OPTION VALUE='L'> L </OPTION>
							<OPTION VALUE='M'> M </OPTION>
							<OPTION VALUE='N'> N </OPTION>
							<OPTION VALUE='O'> O </OPTION>
							<OPTION VALUE='P'> P </OPTION>
							<OPTION VALUE='Q'> Q </OPTION>
							<OPTION VALUE='R'> R </OPTION>
							<OPTION VALUE='S'> S </OPTION>
							<OPTION VALUE='T'> T </OPTION>
							<OPTION VALUE='U'> U </OPTION>
							<OPTION VALUE='V'> V </OPTION>
							<OPTION VALUE='W'> W </OPTION>			
							<OPTION VALUE='X'> X </OPTION>
							<OPTION VALUE='Y'> Y </OPTION>
							<OPTION VALUE='Z'> Z </OPTION>		
							<OPTION VALUE='all'> all </OPTION>					
						</select>
					</td>");
					
					// retrieve ALL authors from table AUTHOR:
								$type_1 -> retrive_name();
				    $type_1->retrive_nickname();
					$n_neuron_total_name = $type_1 -> getName_neuron();
					$n_neuron_total_nickname = $type_1 -> getNickname_neuron();
					// keep only the authors that have the first letter = $letter_t:
					$n_neuron = 0;
					$name_neuron = NULL;
					for ($i1=0; $i1<$n_neuron_total_name; $i1++)
					{
						$name_neuron1 = $type_1 -> getName_neuron_array($i1);
					//$name_neuron4 = $type_1 -> getNickname_neuron_array($i1);
			
						if ($letter_t == 'all')
						{
							$name_neuron[$n_neuron] = $name_neuron1;
							
							$n_neuron = $n_neuron + 1;						
						}
						else
						{
						
							if ($name_neuron1[0] == $letter_t)
							{
								$name_neuron[$n_neuron] = $name_neuron1;
								$n_neuron = $n_neuron + 1;
							}
						}
										
								
                      						
					}
				sort($name_neuron);	
				$n_count=$n_neuron;
					
			// new method
		$name_neuronx = NULL;
	for ($i1=0; $i1<$n_neuron_total_nickname; $i1++)
					{
						//$name_neuron1 = $type_1 -> getName_neuron_array($i1);
					$name_neuron4 = $type_1 -> getNickname_neuron_array($i1);
			
						if ($letter_t == 'all')
						{
							$name_neuronx[$n_neuron] = $name_neuron4;
							
							$n_neuron = $n_neuron + 1;						
						}
						else
						{
						
							if ($name_neuron4[0] == $letter_t)
							{
							    $name_neuronx[$n_neuron] = $name_neuron4;
								$n_neuron = $n_neuron + 1;
							}
						}
											
                       		    							
					}	

                 
					//natcasesort($name_neuronx); 
					
			
				
						print ("<td align='center' width='20%' class='table_neuron_page1'>");
										
					print ("<select name='neuron1' size='1' cols='10' class='select1' onChange=\"type(this, $id)\">");
		
					$temporary -> retrieve_neuron_from_id($id);
					$name_neuron_right = $temporary -> getNeuron();		
				
					if ($name_neuron_right)
					{
						$temp_neuron= htmlspecialchars($name_neuron_right,ENT_QUOTES);	
						echo "<option value='".$temp_neuron."'>".stripslashes($name_neuron_right)."</option>";
						print ("<OPTION VALUE='' disabled></OPTION>");
					}	
					
						if ($n_neuron == 0)
					{
						print ("<OPTION VALUE=''>-</OPTION>");	
					}
					else
					{
						for ($i1=0; $i1<$n_count; $i1++)
						{
							$temp_neuron= htmlspecialchars($name_neuron[$i1],ENT_QUOTES);	
							echo "<option value='".$temp_neuron."'>".$name_neuron[$i1]. "</option>";
			   
						}
		
						for ($i1=$n_count; $i1<$n_neuron; $i1++)
						{
							$temp_neuron= htmlspecialchars($name_neuronx[$i1],ENT_QUOTES);	
			                echo "<option value='".$temp_neuron."'>".$name_neuronx[$i1]. "</option>";
						}
						
						
					}
					
					print ("</select>");
					print ("</td><td align='center' width='5%'>
								<form action='find_neuron_name.php' method='post' style='display:inline'> 
								<input type='submit' name='plus' value=' + ' class='more_button'>
								</form>
							 </td>");
										
					if ($i > 0)		 
						print ("</td><td align='center' width='5%'>
									<form action='find_neuron_name.php' method='post' style='display:inline'> 
									<input type='submit' name='remove' value=' - ' class='more_button'>
									<input type='hidden' name='id' value='$id'>
									</form>
								 </td>");
					else
						print ("</td><td align='center' width='5%'> </td>");
					
					print ("</td><td align='center' width='40%'>  </td>");
					
}
?>
		</tr>
	</table>
	
	<br />
	
	<table border="0" cellspacing="3" cellpadding="0" class='table_search'>
	<tr>		
		<td width="100%" align="center">
		
		<?php
			if (($and_or == 'AND') && ($n_search > 1))
			{
				print ("<input type='radio' name='and_or' value='AND' checked='checked'/> 
					<font class='font12'>AND</font> ");
				print ("<input type='radio' name='and_or' value='OR' onClick=\"javascript:location.href='find_neuron_name.php?and_or=OR'\"/>  
					<font class='font12'>OR</font>");
			}
			if (($and_or == 'OR') && ($n_search > 1))
			{
				print ("<input type='radio' name='and_or' value='AND' onClick=\"javascript:location.href='find_neuron_name.php?and_or=AND'\" />  
					<font class='font12'>AND </font>");
				print ("<input type='radio' name='and_or' value='OR' checked='checked'/> 
					<font class='font12'>OR</font>");
			}			
		?>				
		</td>
	</tr>
	</table>
	
			
	<br /><br /><br /> 
	

	<div align="center" >
	<table width='250px'>
		<tr>
		<td><form action="find_neuron_name.php" method="post" style='display:inline'>	
			<input type='submit' name='clear_all' value='CLEAR ALL' />
		</form></td>
		<td width='20%'></td>
		<td width='40%'><form action='find_neuron_name.php' method='post' style='display:inline'> 
			<input type="submit" name='see_result' value='SEE RESULTS' />
				
		</form></td>
		</tr>
	</table>
	
	<br /><br /><br />
	
	<?php
		if ($_REQUEST['see_result'])
		{
			
			print ("<table border='0'  class='table_result' id='tab_res' width='100%'>");
			print ("<thead><tr>
						<th align='center' width='40%' class='table_neuron_page1'> <strong>Name</strong> </th>
						<th align='center' width='20%' class='table_neuron_page1'> <strong>Synonym </strong></th>										
					</tr></thead><tbody>");
				
				//$temporary -> retrieve_id();			
			//$mm = $temporary -> getN_id();
							print ("<tr>
						<td align='left' width='20%' class='table_neuron_page4'>$names[j3]</td>");
				}
				
				
					?>
	
	<br /><br />

	</div>
</div>
</body>
</html>

