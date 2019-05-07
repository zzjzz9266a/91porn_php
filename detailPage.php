<?php 
require 'vendor/autoload.php';
require 'Aria2.php';
use DiDom\Document;
use DiDom\Query;

function random_ip()
{
	$a = rand(0, 255);
	$b = rand(0, 255);
	$c = rand(0, 255);
	$d = rand(0, 255);
	return $a.'.'.$b.'.'.$c.'.'.$d;
}

function singlePage($page_url, $title)
{
	if (checkExist($title)) {
		return;
	}
	

	$html = getHtml($page_url);
	$page = new Document($html);

	$cipher = $page->first('#vid')->first('script')->text();
	$videoUrl = decode($cipher);
    echo $videoUrl."\n";
   	
   	download($videoUrl, $title);

}

function getHtml($url) {
	$header = array();
	$header[] = "Accept-Language:zh-CN,zh;q=0.9";
	$header[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko)Chrome/51.0.2704.106 Safari/537.36";
	$header[] = "X-Forwarded-For:".random_ip();
	$header[] = "Content-Type: multipart/form-data; session_language=cn_CN";
	$header[] = "Referer:".$url;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT,300);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	// curl_setopt($ch, CURLOPT_PROXY, 'http://127.0.0.1:1087');	//代理地址
	// curl_setopt($ch, CURLOPT_PROXY, 'socks5://127.0.0.1:1086');	//代理地址

	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function decode($cipher)
{
	$js = file_get_contents('http://91porn.com/js/md5.js');
	$file = fopen('./md5.js',"w+");
	fputs($file,$js.'console.log(strencode(process.argv[2], process.argv[3], process.argv[4]));');//写入文件
	fclose($file);
	$cipher = substr($cipher, 55);
	$cipher = substr($cipher, 0, strlen($cipher)-19);
	$cipher = str_replace('","', ' ', $cipher);
	$tag = shell_exec('node ./md5.js '.$cipher);
	$videoUrl = explode("<source src='", $tag)[1];
	$videoUrl = explode("' type='video/mp4", $videoUrl)[0];
	return $videoUrl;
}

function download($videoUrl, $title) {
	$aria2 = new Aria2('http://127.0.0.1:6800/jsonrpc');
   	$result = $aria2->addUri(
		[$videoUrl],
		['dir'=>__DIR__.'/videos', 'out'=>$title.'.mp4']
	);
	if ($result['result']) {
		echo "\033[0;32m"."提交Aria2成功!"."\033[0m\n";
	}else {
		echo "\033[0;31m"."提交Aria2失败！！！"."\033[0m\n";
	}
}

function checkExist($title) {
	$filePath = __DIR__.'/videos/'.$title.'.mp4';

	if (file_exists($filePath)){
		echo "\033[0;34m"."文件已存在"."\033[0m\n";
		return true;
	}

	$aria2 = new Aria2('http://127.0.0.1:6800/jsonrpc');

	foreach ($aria2->tellActive()['result'] as $item) {
		if ($item['files'][0]['path'] == $filePath) {
			echo "\033[0;34m"."该视频正在下载"."\033[0m\n";
			return true;
		}
	}

	foreach ($aria2->tellWaiting(0, 1000)['result'] as $item) {
		if ($item['files'][0]['path'] == $filePath) {
			echo "\033[0;34m"."该视频正在等待下载"."\033[0m\n";
			return true;
		}
	}

	foreach ($aria2->tellStopped(0, 1000)['result'] as $item) {
		if ($item['files'][0]['path'] == $filePath) {
			echo "\033[0;34m"."该视频已经下载"."\033[0m\n";
			return true;
		}
	}
	return false;
}

if (count($argv)>1) {
	singlePage($argv[1], "");
}
