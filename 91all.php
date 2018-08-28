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

function listPage($baseUrl)
{
	$header = "Accept-Language:zh-CN,zh;q=0.9\r\nUser-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko)Chrome/51.0.2704.106 Safari/537.36\r\nX-Forwarded-For:".random_ip()."\r\nreferer:http://91porn.com/index.php";
	
	$currentPage = 1;

	$maxPage = 10;	//自行更改页数
	
	while ($currentPage <= $maxPage) {
		$url = $baseUrl."&page=".$currentPage;
		echo "\n".$url."\n";
		try {
			$listPage = new Document($url, true, $header);

			$list = $listPage->find('//*[@class="listchannel"]/a[1]', Query::TYPE_XPATH);
			foreach ($list as $item) {
				$title = $item->getAttribute('title');
				echo "\n".$title."\n";
				$itemUrl = $item->getAttribute('href');
				echo $itemUrl."\n";
				singlePage($itemUrl, $title);
			}
		} catch (Exception $e) {
			echo $e;
		}
		
		$currentPage += 1;
	}
	
}

listPage("http://91porn.com/v.php?category=top&viewtype=basic");	//本月最热
// listPage("http://91porn.com/v.php?category=mf&viewtype=basic");		//收藏最多
// listPage("http://91porn.com/v.php?category=md&viewtype=basic");		//本月讨论