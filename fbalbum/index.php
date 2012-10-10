<?php
	 //error_reporting(E_ALL);
	 //ini_set('display_errors','1');
 
 require_once 'library/facebook.php';
	try{
		$app_id = "422805024446723";
		$app_secret = "403b8ec7294e686a74571967ba27e075";
		$facebook = new Facebook(array(
				'appId' => $app_id,
				'secret' => $app_secret,
				'cookie' => true
		));
	

	if(is_null($facebook->getUser()))
		{
				header("Location:{$facebook->getLoginUrl(array('req_perms' => 'user_status,publish_stream,user_photos'))}");
				exit;
		}
         	$me = $facebook->api('/me');
           
	}catch(Exception $e){
                echo $e->getMessage();
                 die;
	}



?>
<html>
	<head>
		<style type="text/css"> 
		body{font-family: "lucida grande",tahoma,verdana,arial,sans-serif;}
		.alb { margin: auto; width:200px;float:right;padding:20px; }
		.alb p{ background-color: #EDEFF4;  }
		.alb p.hd{ background-color: #EDEFF4;
				color: #1C2A47;
				font-size: 16px;
				font-weight:bold;
				padding:5px;
			}
		.alb p a{ color: #3B5998;
			cursor: pointer;
			text-decoration: none;
			font-size: 11px;
			padding:10px;
			line-height: 25px;
			}
		.slideshow { margin: auto;float:left;padding:20px; }
		.slideshow img { padding: 17px; border: 1px solid #ccc; background-color: #eee; }
		</style> 
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script> 
		<!-- include Cycle plugin --> 
		<script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.latest.js"></script> 
		<script type="text/javascript"> 
		$(document).ready(function() {
			$('.slideshow').cycle({
				fx: 'fade' 
			});
		});
		</script> 
		
		<title>Facebook Albums</title>
	</head>
	<body>
<?php
 	$albums = $facebook->api('/me/albums');
	$action = $_REQUEST['action'];
	$album_id = '';


	if(isset($action) && $action=='viewalbum'){ 
		$album_id = $_REQUEST['album_id'];
		$photos = $facebook->api("/{$album_id}/photos");
		?>
		<div class="slideshow"> 
		<?php
		foreach($photos['data'] as $photo)
		{
			echo "<img src='{$photo['source']}' />";
		}
		?>
		</div>
		<?php
	}

	$pageURL .= 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        	echo '<div class="alb">';
	if(strstr($pageURL,'.php?')){
		$and = '&';
	}else{
		$and = '?';
	}
   if(strstr($pageURL,'session')){
	$pageURL="http://fbal.hostei.com/fbalbum/";
          }

	echo '<p class="hd">My Albums</p>';
	foreach($albums['data'] as $album)
	{
		if($album_id == $album['id']){
			$name = '<b><u>'.$album['name'].'</u></b>';
		}else{
			$name = $album['name'];
		}
		echo '<p>'."<a href=".$pageURL.$and."action=viewalbum&album_id=".$album['id'].">".$name.'</a></p>';
                
	}
 	echo '</div>';
	
	?>
	</body>
</html>