<?php
/*  setup  - create a PHP file called fdownload.php with the lines below.

Change the $filedir to point to you path on the server

Call from a link like this:



*/
//file=http://dl.dropbox.com/u/24735664/2011-10-26-19-48-16.MP3
//$filedir = "/home/yourcpanelname/public_html/" ;
$file = $_GET['file'];
//if (file_exists(basename($file))) {
	//logRegel(basename($file)  ,__FILE__ . __LINE__);
//	echo basename($file);
	header("Content-Description: File Transfer");
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".basename('http://dl.dropbox.com/u/24735664/'.basename($file)));readfile('http://dl.dropbox.com/u/24735664/'.basename($file));
//}else {
//	echo"$file";echo basename($file);
//	echo " No File Found";
//}
?>