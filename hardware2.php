
<?php 
	include("Common/icon.php");
	include("top_hw.html");
	include("Common/mysql.php");
	include("Public/js/date.js");
	include("Public/js/erjiliandong.js");
	include("Common/functions_main.php");
	include("Common/functions_hw.php");
	include('Common/outerror.php');
	$default_time = date("Y-m-d",time());

?>
<script src="laydate/laydate.js"></script> <!-- 改成你的路径 -->
<script>
lay('#version').html('-v'+ laydate.v);

//执行一个laydate实例
laydate.render({
  elem: '#input-date' //指定元素
});
</script>
	<div id="mian">
		<div id="mian-content">
			<form action="post_hw.php" name="myform" method="post">
				<table border="0">
					<tr>
						<th style='text-align:center'><b>地区</b></th>
						<th style='text-align:center'><b>日期</b></th>
						<th style='text-align:center'><b>部门</b></th>
						<th style='text-align:center'><b>提报人</b></th>
						<th style='text-align:center'><b>维护对象</b></th>
						<th style='text-align:center'><b>维护类型</b></th>
						<th style='text-align:center'><b>具体问题</b></th>
						<th style='text-align:center'><b>处理办法</b></th>
						<th style='text-align:center'><b>问题接收人</b></th>
						
						<th>&nbsp;</td>
					</tr>
					<tr>
						<td>
							<select  style="height:30px" name="area"  id="area" onChange="to_area('user');">
								<option value="0">-请选择-</option>
								<?php readarealist() ?>
							</select>
						</td>
						<td><input type="text" id="input-date"  style="text-align:center"  value="<?php echo $default_time?>" name="date" ></td>
						<td>
							<select  style="height:30px" name="department">
								<option value="0">-请选择-</option>
								<?php readdepartment() ?>
							</select>
						</td>
						<td><input type="text"  name="submit_user" maxlength="5" ></td>
						<td>
							<select  style="height:30px" name="object"  id="object" onChange="to_class('type');">
								<option value="0">-请选择-</option>
								<?php readobject() ?>
							</select>
						</td>
						<td>
							<select  style="height:30px" name="type" id="type">
								<option value="0">-请选择-</option>
								
							</select>
						</td>
						<td><input id="index-input" type="text"  name="problem"  maxlength="50"></td>
						<td><input  id="index-input" type="text"  name="method"  maxlength="50"></td>
						<td>
							<select style="height:30px" name="user" id="user">
										<option value="0">--请选择--</option>
										
							</select>
						</td>

						<td><input id="" type="submit" name="submit" value="提  交"></td>
					</tr>
				</table>
			</form>
				
		</div>
	</div>
	<br>
		<?php include("footer_hw.html") ?>