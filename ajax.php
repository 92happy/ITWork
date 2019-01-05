<?php
	$o_id=$_GET['o_id'];  
	include("Common/mysql.php");
	$sql="select t_id,type from hardware_type where o_id='$o_id'";  
	$result=$mysqli->query($sql);
	while($rows=$result->fetch_assoc()){  
		echo "<option value=".$rows['t_id'].">";  
		echo $rows['type'];  
		echo "</option>";  
	}  
	
	$a_id=$_GET['a_id'];
	$sql="select  id,name from user where status='1' and a_id='$a_id';";
	$result=$mysqli->query($sql);
	while($rows=$result->fetch_assoc()){  
		echo "<option value=".$rows['id'].">";  
		echo $rows['name'];  
		echo "</option>";  
	}  


?>  


