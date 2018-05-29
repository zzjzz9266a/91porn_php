<?php 
require 'vendor/autoload.php';
require 'detailPage.php';
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

function listPage()
{
	$url = "http://91porn.com/index.php";

	$header = "User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36\r\nAccept-Language: zh-CN,zh;q=0.9,en;q=0.8,zh-TW;q=0.7";
	$listPage = new Document($url, true, $header);
	$list = $listPage->find('//*[@id="tab-featured"]/p/a[2]', Query::TYPE_XPATH);
	// var_dump($url);
	foreach ($list as $page) {
		$title = $page->text();
		echo "\n".$title."\n";
		$pageUrl = $page->getAttribute('href');
		echo $pageUrl."\n";
		singlePage($pageUrl, $title);
	}
}

listPage();
