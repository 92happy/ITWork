<script language="javascript" >  
	var http_request=false;  
  function send_request(url){//初始化，指定处理函数，发送请求的函数  
    http_request=false;  
 //开始初始化XMLHttpRequest对象  
 if(window.XMLHttpRequest){//Mozilla浏览器  
  http_request=new XMLHttpRequest();  
  if(http_request.overrideMimeType){//设置MIME类别  
    http_request.overrideMimeType("text/xml");  
  }  
 }  
 else if(window.ActiveXObject){//IE浏览器  
  try{  
   http_request=new ActiveXObject("Msxml2.XMLHttp");  
  }catch(e){  
   try{  
   http_request=new ActiveXobject("Microsoft.XMLHttp");  
   }catch(e){}  
  }  
    }  
 if(!http_request){//异常，创建对象实例失败  
  window.alert("创建XMLHttp对象失败！");  
  return false;  
 }  
 http_request.onreadystatechange=processrequest;  
 //确定发送请求方式，URL，及是否同步执行下段代码  
    http_request.open("GET",url,true);  
 http_request.send(null);  
  }  
  //处理返回信息的函数  
	function processrequest(){  
		//window.alert(http_request.readyState);
		if(http_request.readyState==4){//判断对象状态  
			//window.alert(http_request.readyState);
			//window.alert(http_request.status);
			if(http_request.status==200){//信息已成功返回，开始处理信息  
				
				document.getElementById(reobj).innerHTML=http_request.responseText;  
			}else{//页面不正常  
				window.alert(http_request.status);
			}  
		}  
	}  

	function to_class(obj){  
		var o_id=document.myform.object.value;  
		//window.alert(o_id);
		document.getElementById(obj).innerHTML="<option>loading...</option>";  
		send_request('ajax.php?o_id='+o_id);  
		reobj=obj;  
	}  
   	function to_area(obj){  
		var a_id=document.myform.area.value;  
		//window.alert(o_id);
		document.getElementById(obj).innerHTML="<option>loading...</option>";  
		send_request('ajax.php?a_id='+a_id);  
		reobj=obj;  
	}  
</script>  