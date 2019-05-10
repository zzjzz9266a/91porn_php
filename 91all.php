<?php 
require 'detailPage.php';
use DiDom\Document;
use DiDom\Query;

function listPage($baseUrl)
{	
	$currentPage = 1;

	$maxPage = 10;	//自行更改页数
	
	while ($currentPage <= $maxPage) {
		$url = $baseUrl."&page=".$currentPage;
		echo "\n".$url."\n";
		try {
			$html = getHtml($url);
			$listPage = new Document($html);

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