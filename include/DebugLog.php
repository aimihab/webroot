<?php
function msg_debug($content) {
	file_put_contents('/home/art/project_art_teach/src/webroot/log.txt', "[".date('Y-m-d H:i:s')."] ".$content."\r\n",FILE_APPEND);
}
?>
