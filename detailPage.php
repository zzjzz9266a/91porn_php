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
	$defaultPath = './videos';
	if (!is_dir($defaultPath)) {
		mkdir($defaultPath);
	}
	$filePath = $defaultPath.'/'.$title.'.mp4';
	if (file_exists($filePath)){
		echo "\033[0;34m"."文件已存在"."\033[0m\n";
		return;
	}

	$header = "Accept-Language:zh-CN,zh;q=0.9\r\nUser-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko)Chrome/51.0.2704.106 Safari/537.36\r\nX-Forwarded-For:".random_ip()."\r\nreferer:".$page_url."\r\nContent-Type: multipart/form-data; session_language=cn_CN";
	$page = new Document($page_url, true, $header);
	$date = $page->find('//*[@id="videodetails-content"]/span[2]', Query::TYPE_XPATH)[0]->text();

	$shareLink = $page->first('#linkForm2')->first('#fm-video_link')->text();
	$sharePage = new Document(file_get_contents($shareLink), false, $header);

	$videoUrl = $sharePage->first('source')->getAttribute('src');
    echo $videoUrl."\n";
   	
   	download($videoUrl, $title);

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

if (count($argv)>1) {
	singlePage($argv[1], "");
}
