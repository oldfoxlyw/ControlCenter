<?php
// 此PHP程序配合Cron jobs使用可以定期自动产生cPanel备份,
// 以max.hedroom在cpanel.net论坛的文章为程序基础,
// 这个程序包含密码, 请注意档案安全.
// 中文翻译修正：Fred, http://www.ifred.cn/cp-full-backup
// ********* 下列项目需要设定 *********
// cPanel登入信息
$cpuser = "tdatctsc"; // 登入cPanel的账号
$cppass = "2w]3H@7J9MUC"; // 登入cPanel的密码
$domain = "67.228.91.226"; // cPanel绑定的域名(或ip)
$skin = "x3"; // 设定正在使用的cPanel模板(例如:x, x3, rvblue)
// FTP上传的信息
$ftpuser = "tdatctsc"; // FTP账号
$ftppass = "2w]3H@7J9MUC"; // FTP密码
$ftphost = "67.228.91.226"; // FTP服务器网址(或ip)
$ftpmode = "ftp"; // FTP模式("ftp"或"passiveftp")
$ftpport = "21"; // Port (default = 21)
$rdir = "/public_html/_backup/"; // Remote dir (defaut = / )
// 通知信息
$notifyemail = "johnnyeven.work@gmail.com"; // 寄发执行结果的e-mail位置
// 安全模式
$secure = 0; // 0为标准http, 1为ssl(需要主机支持ssl功能)
// 设定值为1时会在排程记录中产生网页报告
$debug = 0;
// *********** 以下不需更改 *********
if ($secure) {
$url = "ssl://".$domain;
$port = 2083;
} else {
$url = $domain;
$port = 2082;
}
$socket = fsockopen($url,$port);
if (!$socket) { echo "Failed to open socket connection... Bailing out!\n"; exit; }
// Encode authentication string
$authstr = $cpuser.":".$cppass;
$pass = base64_encode($authstr);
$params = "dest=$ftpmode&email=$notifyemail&server=$ftphost&user=$ftpuser&pass=$ftppass&port=$ftpport&rdir=$rdir&submit=Generate Backup";
// Make POST to cPanel
fputs($socket,"POST /frontend/".$skin."/backup/dofullbackup.html?".$params." HTTP/1.0\r\n");
fputs($socket,"Host: $domain\r\n");
fputs($socket,"Authorization: Basic $pass\r\n");
fputs($socket,"Connection: Close\r\n");
fputs($socket,"\r\n");
// Grab response even if we don't do anything with it.
while (!feof($socket)) {
$response = fgets($socket,4096);
if ($debug) echo $response;
}
fclose($socket);
?>