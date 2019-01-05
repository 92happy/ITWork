<?php
	include("Common/icon.php");
	include("Common/mysql.php");
	include('Common/outerror.php');
			
	$ip = $_SERVER["REMOTE_ADDR"];
	$area  = $_POST["area"];
	$date = $_POST["date"];
	$department = $_POST["department"];
	$submit_user = trim($_POST["submit_user"]);
	$object = $_POST["object"];
	$type = $_POST["type"];
	$problem = trim($_POST["problem"]);
	$method = trim($_POST["method"]);
	$user = $_POST["user"];
	$week = date('W',strtotime($date));

	if ( $area == 0 || $department == 0 || $submit_user == '' ||  $object == 0 ||  $type == 0 || $problem == '' || $method == '' || $user == 0){
		echo "<script>alert('提交失败,提交内容不完整');location.href='http://10.128.112.3/itwork/hardware.php'</script>"; 
	} else {
		$sql = "INSERT INTO hardware_problem(a_id,p_date,d_id,submit_user,o_id,t_id,problem,method,u_id,week,ip_address) 
							VALUES('{$area}','{$date}','{$department}','{$submit_user}','{$object}','{$type}','{$problem}','{$method}','{$user}','{$week}','{$ip}')";
		$mysqli->query($sql);
		echo "<script>alert('提交成功');location.href='http://10.128.112.3/itwork/p_list_hw.php'</script>"; 
	}


?>

