<?php

	//echo date('W',strtotime($data));

	function auto_week_num_sys(){
		include("Common/mysql.php");
		$sql = "select p_id,p_date,week from system_problem where week is NULL;;";
		$result=$mysqli->query($sql);	
			if ($result->num_rows>0){
				
				while ($rows = $result->fetch_assoc()){
					
					$date = $rows['p_date'];
				
					$week_num=date('W',strtotime($date));
					$sql2 = "update system_problem set week='{$week_num}' where p_id='{$rows["p_id"]}';";
					$mysqli->query($sql2);
					if ($mysqli->affected_rows>0){
						echo '执行成功，受影响行:'.$mysqli->affected_rows.'<br>';
					} else {
						echo '没有影响行';
					}
				}
			} else {
				echo "<option value=''>无</option>";
			}
	}

	//auto_week_num_sys();


	function auto_week_num_hw(){
		include("Common/mysql.php");
		$sql = "select p_id,p_date,week from hardware_problem where week is NULL;;";
		$result=$mysqli->query($sql);	
			if ($result->num_rows>0){
				
				while ($rows = $result->fetch_assoc()){
					
					$date = $rows['p_date'];
				
					$week_num=date('W',strtotime($date));
					$sql2 = "update hardware_problem set week='{$week_num}' where p_id='{$rows["p_id"]}';";
					$mysqli->query($sql2);
					if ($mysqli->affected_rows>0){
						echo '执行成功，受影响行:'.$mysqli->affected_rows.'<br>';
					} else {
						echo '没有影响行';
					}
				}
			} else {
				echo "<option value=''>无</option>";
			}
	}

	//auto_week_num_hw();


?>