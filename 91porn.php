<?php 

require 'detailPage.php';
use DiDom\Document;
use DiDom\Query;

function listPage()
{
	$url = "http://".Config::$url."/index.php";

	$html = getHtml($url);
	$listPage = new Document($html);
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
