<?php 
require 'downloader.php';
use DiDom\Document;
use DiDom\Query;

function singlePage($page_url, $title)
{
	$html = getHtml($page_url);
	$page = new Document($html);

	try {
		$videoUrl = "";
		// 先直接取source
		$source = $page->first('#player_one source');
		if ($source) {
			$videoUrl = $source->getAttribute('src');
			echo "====直接解析====\n";
		}

		// 分享链接也没有的话再解密
		if (!$videoUrl) {
			$cipher = $page->first('#player_one script')->text();	
			$videoUrl = decode($cipher);
			echo "====js解密====\n";
		}

		// 如果source取不到就找分享链接
		if (!$videoUrl) {
			$shareLink = $page->first('#linkForm2 #fm-video_link');
			$sharePage = new Document(getHtml($shareLink->text()));
	    $videoUrl = $sharePage->first('source')->getAttribute('src');
	    echo "====分享链接====\n";
		}
		$date = $page->find('//*[@id="videodetails-content"]/span[2]', Query::TYPE_XPATH)[0]->text();

	  echo $videoUrl."\n";
	 	Downloader::download($videoUrl, $title, $date);
	}catch(Exception $e) {
		echo "这个视频没找到，请排查是否需要挂载代理\n";
	}
	
}

function getHtml($url) {
	$header = array();
	$header[] = "Accept-Language:zh-CN,zh;q=0.9";
	$header[] = "X-Forwarded-For:".random_ip();
	$header[] = "Content-Type: multipart/form-data; session_language=cn_CN";
	$header[] = "Referer:".$url;
	$header[] = "Host:".Config::$url;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT,300);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	if (property_exists('Config', 'proxy') && (Config::$url=='91porn.com')) {
		curl_setopt($ch, CURLOPT_PROXY, Config::$proxy);
	}

	$data = curl_exec($ch);
	curl_close($ch);
	if ($data) {
		return $data;
	}else{
		echo "页面未取回，请排查是否需要挂载代理\n";
	}
}

function decode($cipher)
{
	$js = getHtml('http://'.Config::$url.'/js/md5.js');
	$cipher = explode('document.write(', $cipher)[1];
	$cipher = explode(');', $cipher)[0];
	
	$file = fopen('./md5.js',"w+");
	fputs($file,$js.'console.log('.$cipher.');');//写入文件
	fclose($file);

	$tag = shell_exec('node ./md5.js');
	$videoUrl = explode("<source src='", $tag)[1];
	$videoUrl = explode("' type='video/mp4", $videoUrl)[0];
	return $videoUrl;
}

if (count($argv)>1) {
	singlePage($argv[1], "");
}
