<?php 
require 'downloader.php';
use DiDom\Document;
use DiDom\Query;

function singlePage($page_url, $title)
{
	$html = getHtml($page_url);
	$page = new Document($html);

	$shareLink = $page->first('#linkForm2 #fm-video_link');
	if ($shareLink) {
		$sharePage = new Document(getHtml($shareLink->text()));
		$videoUrl = $sharePage->first('source')->getAttribute('src');
	}else{
		echo "没有分享链接\n";
		$cipher = $page->first('#vid script')->text();
		$videoUrl = decode($cipher);
	}

	$date = $page->find('//*[@id="videodetails-content"]/span[2]', Query::TYPE_XPATH)[0]->text();

    echo $videoUrl."\n";
   	Downloader::download($videoUrl, $title, $date);
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
	if (property_exists('Config', 'proxy')) {
		curl_setopt($ch, CURLOPT_PROXY, Config::$proxy);
	}

	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function decode($cipher)
{
	$js = getHtml('http://91porn.com/js/md5.js');
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

if (count($argv)>1) {
	singlePage($argv[1], "");
}
