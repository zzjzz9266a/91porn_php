<?php 

require 'detailPage.php';
use DiDom\Document;
use DiDom\Query;

function listPage()
{
	$url = "http://".Config::$url."/index.php";

	$html = getHtml($url);
	$listPage = new Document($html);
	$list = $listPage->find('.well a');
	
	foreach ($list as $page) {
		$title = $page->first('.video-title')->text();
		echo "\n".$title."\n";
		$pageUrl = $page->getAttribute('href');
		echo $pageUrl."\n";
		singlePage($pageUrl, $title);
	}
}

listPage();
