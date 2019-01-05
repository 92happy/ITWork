<?php
	function readmodulelist(){
		include("mysql.php");
		$sql = "select m_id,M_name from system_module ";
		$result=$mysqli->query($sql);	
			if ($result->num_rows>0){
				while ($rows = $result->fetch_assoc()){
					if($rows['m_id']==$_SESSION['sys_module']){
						echo "<option value='{$rows['m_id']}' selected='selected'>".$rows['M_name']."</option>";
					} else {
						echo "<option  value='{$rows['m_id']}'>".$rows['M_name']."</option>";
					}
				}
			} else {
				echo "<option value=''>无</option>";
			}
	}

	function readtypeslist(){
		include("mysql.php");
		$sql = "select s_id,system_type from system_types ";
		$result=$mysqli->query($sql);	
			if ($result->num_rows>0){
				while ($rows = $result->fetch_assoc()){
					if($rows['s_id']==$_SESSION['sys_types']){
						echo "<option value='{$rows['s_id']}' selected='selected'>".$rows['system_type']."</option>";
					} else {
						echo "<option name='types' value='{$rows['s_id']}'>".$rows['system_type']."</option>";
					}
				}
			} else {
				echo "<option value=''>无</option>";
			}
	}



//默认都为空
	function  tj_total (){
		include("mysql.php");
		$sql_tj_d="select sm.M_name name,ifnull (cnt,0) num  from system_module sm left join (select m_id,count(*) cnt,p_date from system_problem  group by m_id) sp on sp.m_id=sm.m_id";
		$result_tj_d=$mysqli->query($sql_tj_d);

		if ($result_tj_d->num_rows >0) {
			echo "<div style='height:18px'></div>";
			echo "<table id='report' class='stylized full' width='85%'>";
			echo "<tr><th><b>模块种类</b></th><th><b>销售</b></th><th><b>总账</b></th><th><b>OA</b></th><th><b>SAP</b></th><th><b>饲料厂</b></th><th><b>分级厂</b></th><th><b>农场</b></th><th><b>深加工</b></th><th><b>液蛋厂</b></th><th><b>总数量</b></th></tr>";
			echo "<tr><td  id='td-bj'><b>问题数量</b></td>";

			while ($row_tj_d = $result_tj_d->fetch_assoc()){
				echo "<td  style='text-align:center'>".$row_tj_d['num'].'</td>';
			}
			$sql_tj_d_total="select sum(cnt) p_nums from system_module sm left join (select m_id,count(*) cnt,p_date from system_problem group by m_id) sp on sp.m_id=sm.m_id";
			$result_tj_d_total=$mysqli->query($sql_tj_d_total);
			$p_nums=$result_tj_d_total->fetch_assoc();
			echo "<td><font color='blue' ><b>".$p_nums['p_nums'] =$p_nums['p_nums'] =='' ? 0 : $p_nums['p_nums']."</b></font></td>";
			echo "</tr>";
			echo "</table>";
			echo "<br>";

		} else {
			echo "<br><br><br>无统计信息<br><br>";
		}

		$sql = "select p_id from system_problem";
		$result = $mysqli->query($sql);
		$total = $result->num_rows;
		$num = 10;
		$page=new Page($total, $num, "");

		$sql2="select p_id,p_date,sm.M_name,st.system_type,submit_user,problem,method,u.name,a.area from system_problem sp left join system_module sm  on sp.m_id=sm.m_id left join  system_types st on sp.s_id=st.s_id left join user u on sp.u_id=u.id left join area a on sp.a_id=a.a_id order by p_id desc {$page->limit};";
		$result2 = $mysqli->query($sql2);

		if ($result2->num_rows > 0){
			echo "<table border='1'  cellspacing='0' cellpadding='0' width='85%'>";
			echo "<tr><th width='5%'><b>编号</b></th><th width='10%'><b>日期</b></th><th width='7%'><b>模块</b></th><th width='10%'><b>系统类型</b></th><th width='8%'><b>提报人</b></th><th><b>问题</b></th><th width='25%'><b>处理方法</b></th><th width='6%'><b>处理人</b></th><th width='6%'><b>地区</b></th></tr>";
								
			while ($row2 = $result2->fetch_assoc()){
				echo "<tr>";
				echo "<td style='text-align:center'>".$row2['p_id'].'</td>';
				echo '<td>'.$row2['p_date'].'</td>';
				echo '<td>'.$row2['M_name'].'</td>';
				echo '<td>'.$row2['system_type'].'</td>';
				echo '<td>'.$row2['submit_user'].'</td>';
				echo '<td id="p_stytle">'.$row2['problem'].'</td>';
				echo '<td id="p_stytle">'.$row2['method'].'</td>';
				echo '<td>'.$row2['name'].'</td>';
				echo '<td>'.$row2['area'].'</td>';
				//echo '<td>'.$row2['status']=$row2['status']==1 ? '完成' : '未完成'.'</td>';
				echo "</tr>";
			}
			echo '<tr><td colspan="9" style="text-align:center">'.$page->fpage(array(3,4,5,6,7,0,1,2,8)).'</td></tr>';
			echo "</table>";
		} else {
			echo"<center><font size=4 color=blue>查询完成，没有找到相关信息！</font></center>";
		}
	}



	function system_p_list($start_time,$end_time,$system_module,$system_types,$sys_area,$sys_user){
		include("mysql.php");
		$sql='select sm.M_name name,ifnull (cnt,0) num  from system_module sm left join (select m_id,count(*) cnt,p_date from system_problem where ';
		//123456  12
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .= "p_date >= '{$start_time}' and p_date <= '{$end_time}' ";
			}
		//123456  12-3
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}'  and  m_id='{$system_module}'" ;
			}
		//123456  12-4
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and s_id='{$system_types}'" ;
			}
		//123456  12-5
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and a_id='{$sys_area}'";
			}
		//123456  12-6
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and u_id='{$sys_user}'";
			}
		//123456  12-34
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and m_id='{$system_module}' and  s_id='{$system_types}'";
			}
		//123456  12-35
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and m_id='{$system_module}' and  a_id='{$sys_area}'";
			}
		//123456  12-36
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and m_id='{$system_module}' and  u_id='{$sys_user}'";
			}
		//123456  12-45
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  s_id='{$system_types}' and  a_id='{$sys_area}'";
			}
		//123456  12-46
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  s_id='{$system_types}' and  u_id='{$sys_user}'";
			}
		//123456  12-56
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and   a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  12-345
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  m_id='{$system_module}' and s_id='{$system_types}' and a_id='{$sys_area}'";
			}
		//123456  12-346
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  m_id='{$system_module}' and  s_id='{$system_types}'  and u_id='{$sys_user}'";
			}
		//123456  12-356
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  m_id='{$system_module}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  12-456
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  s_id='{$system_types}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  12-3456
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  m_id='{$system_module}' and s_id='{$system_types}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  3
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .=" m_id='{$system_module}'";
			}
		//123456  4
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .=" s_id='{$system_types}'";
			}
		//123456  5
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .=" a_id='{$sys_area}'";
			}
		//123456  6
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .=" u_id='{$sys_user}'";
			}
		//123456  34
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .="  m_id='{$system_module}' and s_id='{$system_types}'";
			}
		//123456  35
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="  m_id='{$system_module}' and a_id='{$sys_area}'";
			}
		//123456  36
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="  m_id='{$system_module}' and u_id='{$sys_user}'";
			}
		//123456  45
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="  s_id='{$system_types}' and a_id='{$sys_area}'";
			}
		//123456  46
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="  s_id='{$system_types}' and  u_id='{$sys_user}'";
			}
		//123456  56
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="  a_id='{$sys_area}' and  u_id='{$sys_user}'";
			}
		//123456  345
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="  m_id='{$system_module}' and s_id='{$system_types}' and a_id='{$sys_area}'";
			}
		//123456  346
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="  m_id='{$system_module}' and  s_id='{$system_types}'  and u_id='{$sys_user}'";
			}
		//123456  356
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="  m_id='{$system_module}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  456
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .=" s_id='{$system_types}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  3456
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .=" m_id='{$system_module}' and s_id='{$system_types}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}

		$sql .=" group by m_id) sp on sp.m_id=sm.m_id";

		$result=$mysqli->query($sql);
		if ($result->num_rows >0) {
			echo "<div style='height:18px'></div>";
			echo "<table id='report' class='stylized full' width='85%'>";
			echo "<tr><th><b>模块种类</b></th><th><b>销售</b></th><th><b>总账</b></th><th><b>OA</b></th><th><b>SAP</b></th><th><b>饲料厂</b></th><th><b>分级厂</b></th><th><b>农场</b></th><th><b>深加工</b></th><th><b>液蛋厂</b></th><th><b>总数量</b></th></tr>";
			echo "<tr><td  id='td-bj'><b>问题数量</b></td>";

			while ($row = $result->fetch_assoc()){
				echo "<td  style='text-align:center'>".$row['num'].'</td>';
			}
			
			$sql = "select sum(cnt) p_nums  from system_module sm left join (select m_id,count(*) cnt,p_date from system_problem where ";
			if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .= "p_date >= '{$start_time}' and p_date <= '{$end_time}' ";
			}
		//123456  12-3
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}'  and  m_id='{$system_module}'" ;
			}
		//123456  12-4
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and s_id='{$system_types}'" ;
			}
		//123456  12-5
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and a_id='{$sys_area}'";
			}
		//123456  12-6
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and u_id='{$sys_user}'";
			}
		//123456  12-34
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and m_id='{$system_module}' and  s_id='{$system_types}'";
			}
		//123456  12-35
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and m_id='{$system_module}' and  a_id='{$sys_area}'";
			}
		//123456  12-36
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and m_id='{$system_module}' and  u_id='{$sys_user}'";
			}
		//123456  12-45
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  s_id='{$system_types}' and  a_id='{$sys_area}'";
			}
		//123456  12-46
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  s_id='{$system_types}' and  u_id='{$sys_user}'";
			}
		//123456  12-56
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and   a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  12-345
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  m_id='{$system_module}' and s_id='{$system_types}' and a_id='{$sys_area}'";
			}
		//123456  12-346
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  m_id='{$system_module}' and  s_id='{$system_types}'  and u_id='{$sys_user}'";
			}
		//123456  12-356
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  m_id='{$system_module}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  12-456
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  s_id='{$system_types}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  12-3456
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="p_date >= '{$start_time}' and p_date <= '{$end_time}' and  m_id='{$system_module}' and s_id='{$system_types}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  3
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .=" m_id='{$system_module}'";
			}
		//123456  4
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .=" s_id='{$system_types}'";
			}
		//123456  5
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .=" a_id='{$sys_area}'";
			}
		//123456  6
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .=" u_id='{$sys_user}'";
			}
		//123456  34
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user == 0 ){
			$sql .="  m_id='{$system_module}' and s_id='{$system_types}'";
			}
		//123456  35
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="  m_id='{$system_module}' and a_id='{$sys_area}'";
			}
		//123456  36
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="  m_id='{$system_module}' and u_id='{$sys_user}'";
			}
		//123456  45
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="  s_id='{$system_types}' and a_id='{$sys_area}'";
			}
		//123456  46
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="  s_id='{$system_types}' and  u_id='{$sys_user}'";
			}
		//123456  56
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="  a_id='{$sys_area}' and  u_id='{$sys_user}'";
			}
		//123456  345
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user == 0 ){
			$sql .="  m_id='{$system_module}' and s_id='{$system_types}' and a_id='{$sys_area}'";
			}
		//123456  346
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0 && $sys_area == 0  &&  $sys_user != 0 ){
			$sql .="  m_id='{$system_module}' and  s_id='{$system_types}'  and u_id='{$sys_user}'";
			}
		//123456  356
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="  m_id='{$system_module}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			//echo $sql;
			//exit;
			}
		//123456  456
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .=" s_id='{$system_types}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}
		//123456  3456
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0 && $sys_area != 0  &&  $sys_user != 0 ){
			$sql .="m_id='{$system_module}' and s_id='{$system_types}' and  a_id='{$sys_area}'  and u_id='{$sys_user}'";
			}

			$sql .= " group by m_id) sp on sp.m_id=sm.m_id";
	
			$result2=$mysqli->query($sql);
			$p_nums=$result2->fetch_assoc();
			echo "<td><font color='blue' ><b>".$p_nums['p_nums'] =$p_nums['p_nums'] =='' ? 0 : $p_nums['p_nums'] ."</b></font></td>";
			echo "</tr>";
			echo "</table>";
			echo "<br>";
		} else {
			echo "<br><br><br>无统计信息ERROR(0)<br><br>";
		}

			$sql = "select p_id,p_date,sm.M_name,st.system_type,submit_user,problem,method,u.name,a.area from system_problem sp left join system_module sm  on sp.m_id=sm.m_id left join  system_types st on sp.s_id=st.s_id left join user u on sp.u_id=u.id left join area a on sp.a_id=a.a_id where  ";

			if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0 &&  $sys_user == 0 && $sys_area == 0 ){
			$sql .= "sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' ";
			}
		//123456  12-3
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0 &&  $sys_user == 0 && $sys_area == 0  ){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}'  and  sp.m_id='{$system_module}'" ;
			}
		//123456  12-4
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0   &&  $sys_user == 0 && $sys_area == 0 ){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and sp.s_id='{$system_types}'" ;
			}
		//123456  12-5
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0   &&  $sys_user == 0 && $sys_area != 0 ){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and sp.a_id='{$sys_area}'";
			}
		//123456  12-6
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0  &&  $sys_user != 0 && $sys_area == 0 ){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and sp.u_id='{$sys_user}'";
			}
		//123456  12-34
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0 &&  $sys_user == 0 && $sys_area == 0 ){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and sp.m_id='{$system_module}' and  sp.s_id='{$system_types}'";
			}
		//123456  12-35
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0 &&  $sys_user == 0 && $sys_area != 0 ){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and sp.m_id='{$system_module}' and  sp.a_id='{$sys_area}'";
			}
		//123456  12-36
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0  &&  $sys_user != 0  && $sys_area == 0){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and sp.m_id='{$system_module}' and  sp.u_id='{$sys_user}'";
			}
		//123456  12-45
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0  &&  $sys_user == 0  && $sys_area != 0){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and  sp.s_id='{$system_types}' and  sp.a_id='{$sys_area}'";
			}
		//123456  12-46
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0  &&  $sys_user != 0  && $sys_area == 0){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and  sp.s_id='{$system_types}' and  sp.u_id='{$sys_user}'";
			}
		//123456  12-56
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types == 0  &&  $sys_user != 0  && $sys_area != 0){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and   sp.a_id='{$sys_area}'  and sp.u_id='{$sys_user}'";
			}
		//123456  12-345
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0  &&  $sys_user == 0  && $sys_area != 0){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and  sp.m_id='{$system_module}' and sp.s_id='{$system_types}' and sp.a_id='{$sys_area}'";
			}
		//123456  12-346
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0  &&  $sys_user != 0  && $sys_area == 0){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and  sp.m_id='{$system_module}' and  sp.s_id='{$system_types}'  and sp.u_id='{$sys_user}'";
			}
		//123456  12-356
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types == 0  &&  $sys_user != 0  && $sys_area != 0){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and  sp.m_id='{$system_module}' and  sp.a_id='{$sys_area}'  and sp.u_id='{$sys_user}'";
			}
		//123456  12-456
		if ($start_time !='' && $end_time !='' &&  $system_module == 0  && $system_types != 0  &&  $sys_user != 0  && $sys_area != 0){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and sp.s_id='{$system_types}' and  sp.a_id='{$sys_area}'  and sp.u_id='{$sys_user}'";
			}
		//123456  12-3456
		if ($start_time !='' && $end_time !='' &&  $system_module != 0  && $system_types != 0  &&  $sys_user != 0  && $sys_area != 0){
			$sql .="sp.p_date >= '{$start_time}' and sp.p_date <= '{$end_time}' and  sp.m_id='{$system_module}' and sp.s_id='{$system_types}' and  sp.a_id='{$sys_area}'  and sp.u_id='{$sys_user}'";
			}
		//123456  3
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0   &&  $sys_user == 0 && $sys_area == 0 ){
			$sql .=" sp.m_id='{$system_module}'";
			}
		//123456  4
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0  &&  $sys_user == 0  && $sys_area == 0){
			$sql .=" sp.s_id='{$system_types}'";
			}
		//123456  5
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types == 0  &&  $sys_user == 0  && $sys_area != 0){
			$sql .=" sp.a_id='{$sys_area}'";
			}
		//123456  6
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types == 0  &&  $sys_user != 0  && $sys_area == 0){
			$sql .=" sp.u_id='{$sys_user}'";
			}
		//123456  34
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0   &&  $sys_user == 0 && $sys_area == 0 ){
			$sql .="  sp.m_id='{$system_module}' and sp.s_id='{$system_types}'";
			}
		//123456  35
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0   && $sys_user == 0  && $sys_area != 0 ){
			$sql .="  sp.m_id='{$system_module}' and sp.a_id='{$sys_area}'";
			}
		//123456  36
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0 &&  $sys_user != 0  && $sys_area == 0 ){
			$sql .="  sp.m_id='{$system_module}' and sp.u_id='{$sys_user}'";
			}
		//123456  45
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0  &&  $sys_user == 0  && $sys_area != 0){
			$sql .="  sp.s_id='{$system_types}' and sp.a_id='{$sys_area}'";
			}
		//123456  46
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0  &&  $sys_user != 0  && $sys_area == 0){
			$sql .="  sp.s_id='{$system_types}' and  sp.u_id='{$sys_user}'";
			}
		//123456  56
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types == 0  &&  $sys_user != 0  && $sys_area != 0){
			$sql .="  sp.a_id='{$sys_area}' and  sp.u_id='{$sys_user}'";
			}
		//123456  345
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0  &&  $sys_user == 0  && $sys_area != 0){
			$sql .="  sp.m_id='{$system_module}' and sp.s_id='{$system_types}' and sp.a_id='{$sys_area}'";
			}
		//123456  346
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0  &&  $sys_user != 0  && $sys_area == 0){
			$sql .="  sp.m_id='{$system_module}' and  sp.s_id='{$system_types}'  and sp.u_id='{$sys_user}'";
			}
		//123456  356
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types == 0  &&  $sys_user != 0  && $sys_area != 0){
			$sql .="  sp.m_id='{$system_module}' and  sp.a_id='{$sys_area}'  and sp.u_id='{$sys_user}'";
			}
		//123456  456
		if ($start_time =='' && $end_time =='' &&  $system_module == 0  && $system_types != 0  &&  $sys_user != 0  && $sys_area != 0){
			$sql .=" sp.s_id='{$system_types}' and  sp.a_id='{$sys_area}'  and sp.u_id='{$sys_user}'";
			}
		//123456  3456
		if ($start_time =='' && $end_time =='' &&  $system_module != 0  && $system_types != 0  &&  $sys_user != 0  && $sys_area != 0){
			$sql .="sp.m_id='{$system_module}' and sp.s_id='{$system_types}' and  sp.a_id='{$sys_area}'  and sp.u_id='{$sys_user}'";
			}
		
			$sql .= " order by sp.p_id desc;";

		$result3 = $mysqli->query($sql);
		if ($result3->num_rows > 0){
			echo "<table border='1'  cellspacing='0' cellpadding='0' width='85%'>";
			echo "<tr><th width='5%'><b>编号</b></th><th width='10%'><b>日期</b></th><th width='7%'><b>模块</b></th><th width='10%'><b>系统类型</b></th><th width='8%'><b>提报人</b></th><th><b>问题</b></th><th width='25%'><b>处理方法</b></th><th width='6%'><b>处理人</b></th><th width='6%'><b>地区</b></th></tr>";
								
			while ($row2 = $result3->fetch_assoc()){
				echo "<tr>";
				echo "<td style='text-align:center'>".$row2['p_id'].'</td>';
				echo '<td>'.$row2['p_date'].'</td>';
				echo '<td>'.$row2['M_name'].'</td>';
				echo '<td>'.$row2['system_type'].'</td>';
				echo '<td>'.$row2['submit_user'].'</td>';
				echo '<td id="p_stytle">'.$row2['problem'].'</td>';
				echo '<td id="p_stytle">'.$row2['method'].'</td>';
				echo '<td>'.$row2['name'].'</td>';
				echo '<td>'.$row2['area'].'</td>';
				//echo '<td>'.$row2['status']=$row2['status']==1 ? '完成' : '未完成'.'</td>';
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo"<center><font size=4 color=blue>ERROR(0011)查询失败，没有找到相关信息！</font></center>";
		}


	}

