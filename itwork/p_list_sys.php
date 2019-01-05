<?php	
	include("Common/icon.php");
		//echo $_REQUEST['opt'];
/*		if ($_REQUEST['opt'] == "export"){//导出的操作
			$file_type = "vnd.ms-excel";
			$file_ending = "xls";
			$default_time = date("Ymd",time());
			$filename = $default_time.rand(1000,9999);
			header("Content-Type: application/$file_type;charset=utf-8");
			header("Content-Disposition: attachment; filename=$filename.$file_ending");
			header("Pragma: no-cache");
			header("Expires: 0");
									
					}
	*/
	include("top_sys.html");
	include("Common/mysql.php");
	//include("Public/js/date.js");
	include("Common/page.class.php");
	include("Common/functions_main.php");
	include("Common/functions_sys.php");
	include('Common/outerror.php');
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	//print_r ($_POST);

	$select_sys_module = isset($_POST['system_module'])?$_POST['system_module']:''; 
	$select_sys_types = isset($_POST['system_types'])?$_POST['system_types']:''; 
	$select_sys_area = isset($_POST['system_area'])?$_POST['system_area']:''; 
	$select_sys_user = isset($_POST['system_user'])?$_POST['system_user']:''; 
	$_SESSION['sys_module']=$select_sys_module;
	$_SESSION['sys_types']=$select_sys_types;
	$_SESSION['area']=$select_sys_area;
	$_SESSION['user']=$select_sys_user;
	//print_r($_SESSION);

?>

	<style type="text/css">
		table, th,td {
		text-align:center;
		letter-spacing:1px;
		 }

	</style>
<script src="layui/layui.js" charset="utf-8"></script>
<script>
layui.use('laydate', function(){
  var laydate = layui.laydate;
  //同时绑定多个
  lay('.half').each(function(){
    laydate.render({
      elem: this
      ,trigger: 'click'
    });
  });
}); 
</script>
	<form name='f_export' action="p_list_sys.php" method="post">
		<label class="required" for="start_time">开始日期:</label>
		<input type="text" id="start_time" class="half"  value="<?php echo $start_time?>"  name="start_time"  style='text-align:center' />

		<label class="required" for="end_time">结束日期:</label>
		<input type="text" id="end_time" class="half"  value="<?php echo $end_time?>"  name="end_time"   style='text-align:center' />

		<label for="select1">模块:</label>
		<select  style="height:30px" name="system_module" >
			<option value="0">-所有-</option>
			<?php readmodulelist() ?>
		</select>
		<label for="select1">系统类型:</label>
		<select style="height:30px" name="system_types">
			<option value="0">--所有--</option>
			<?php readtypeslist() ?>
		</select>

		<label for="select1">处理人:</label>
		<select  style="height:30px" name="system_user" >
			<option value="0">-所有-</option>
			<?php readuserlist_all() ?>
		</select>
		<label for="select1">地区:</label>
		<select  style="height:30px" name="system_area" >
			<option value="0">-所有-</option>
			<?php readarealist() ?>
		</select>
		<input type='hidden' name='opt' value='export'>
		<input type="submit" name="sub" class="btn btn-green big" value="查&nbsp;&nbsp;询"  />

	</form>
					
<?php
	$system_module=$_POST['system_module'];
	$system_types=$_POST['system_types'];
	$sys_area=$_POST['system_area'];
	$sys_user=$_POST['system_user'];
	if (strtotime($start_time) <= strtotime($end_time)){
			if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user == 0){
				tj_total ();	 
			} else{
				system_p_list($start_time,$end_time,$system_module,$system_types,$sys_area,$sys_user);
			} 
	} else {
		echo "<font color='red' size='4'><b>ERROR(100)非法时间段：开始时间 &nbsp;&nbsp;大于 &nbsp;&nbsp;结束时间</b></font>";
	}

		
	include("footer_sys.html");
	
	?>