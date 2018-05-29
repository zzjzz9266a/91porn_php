<?php 
require 'downloader.php';
use DiDom\Document;
use DiDom\Query;

function singlePage($page_url, $title)
{
	
	$header = "Accept-Language:zh-CN,zh;q=0.9\r\nUser-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko)Chrome/51.0.2704.106 Safari/537.36\r\nX-Forwarded-For:".random_ip()."\r\nreferer:".$page_url."\r\nContent-Type: multipart/form-data; session_language=cn_CN";
	$page = new Document($page_url, true, $header);
	$videoUrl = $page->find('source')[0]->getAttribute('src');
	$date = $page->find('//*[@id="videodetails-content"]/span[2]', Query::TYPE_XPATH)[0]->text();
	Downloader::download($videoUrl, $title, $date);
}