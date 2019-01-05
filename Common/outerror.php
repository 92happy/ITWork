<?php
			ini_set('display_errors','on');            //错误信息
			ini_set('display_startup_errors','on');    //php启动错误信息
			error_reporting(E_ALL & ~E_NOTICE);                    //打印出所有的 错误信息  
			//ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); //将出错信息输出到一个文本文件 