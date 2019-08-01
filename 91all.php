<?php 
require 'detailPage.php';
use DiDom\Document;
use DiDom\Query;

function listPage($baseUrl, $min, $max)
{	
	$currentPage = $min;
	
	while ($currentPage <= $max) {
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

foreach (Config::$all_lists as $page_url => $range) {
	if (is_array($range)) {
		listPage('http://'.Config::$url.'/v.php?'.$page_url, $range[0], $range[1]);
	} else if (is_int($range)) {
		listPage('http://'.Config::$url.'/v.php?'.$page_url, $range, $range);
	}
}