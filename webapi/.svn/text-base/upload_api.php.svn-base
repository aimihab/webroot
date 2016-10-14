<?php include "../include/comm.php"?>
<?php
	function upload_action(){
		if (!empty($_FILES["file"]["name"])) { //提取文件域内容名称，并判断 
			
			//允许上传的文件格式 
			$tp = array("image/gif","image/pjpeg","image/jpeg"); 
			//检查上传文件是否在允许上传的类型 
			if(!in_array($_FILES["file"]["type"],$tp)) 
			{ 
				exit; 
			}//END IF 
			$filetype = $_FILES["file"]["type"]; 
			if($filetype == "image/jpeg"){ 
				$type = ".jpg"; 
			} 
			if ($filetype == "image/jpg") { 
				$type = ".jpg"; 
			} 
			if ($filetype == "image/pjpeg") { 
				$type = ".jpg"; 
			} 
			if($filetype == "image/gif"){ 
				$type = ".gif"; 
			} 
			$path="../../h5/img/";//上传路径 
			if(!file_exists($path)) 
			{ 
				msg_debug($path);
				mkdir("$path", 0700); 
			}

			$path=$path.date("Y")."/";
			if(!file_exists($path)) 
			{ 
				msg_debug($path);
				mkdir("$path", 0700); 
			}

			$path=$path.date("m")."/";
			if(!file_exists($path)) 
			{ 
				msg_debug($path);
				mkdir("$path", 0700); 
			}

			$path=$path.date("d")."/";
			if(!file_exists($path)) 
			{ 
				msg_debug($path);
				mkdir("$path", 0700); 
			}

			if($_FILES["file"]["name"]) 
			{ 
				$today=date("YmdHis"); //获取时间并赋值给变量 
				$file2 = $path.$today.$type; //图片的完整路径 
				$file = $today.$type; //图片名称 
				$flag=1; 
			}//END IF 
				if($flag){
					$arr=array();
					$result=move_uploaded_file($_FILES["file"]["tmp_name"],$file2);
					msg_debug($file2);
					if($result === FALSE){
						$arr["msg"]="上传失败";
					}else{
						$arr["msg"]="上传成功";
						$arr["path"]="img/".date("Y")."/".date("m")."/".date("d")."/".$today.$type;;
					}
					echo json_encode($arr);
				} 
				 
			//特别注意这里传递给move_uploaded_file的第一个参数为上传到服务器上的临时文件 
		}else{
			$arr=array();
			// $arr["msg"]=1000;
			// if($ok === FALSE){
			$arr["msg"]="上传失败";
			// }else{
			// $arr["msg"]="上传成功";
			// }
			echo json_encode($arr);
		}

		

	}

	msg_debug("------------begin-----------------".$_GET["action"]);
	if ( $_GET["action"] != null && $_GET["action"] == "upload" )
	{
		upload_action();
	}
?>
