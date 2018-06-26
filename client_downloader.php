<?PHP

$baseURL = 'http://xxoo.com';
$list = file_get_contents($baseURL);	//改成对应vps的域名或ip
$list = json_decode($list);

$lastDownloaded = 0;
$lastTime = null;

ini_set('memory_limit','512M');

if (!is_dir('./videos')) {
	mkdir('./videos');
}

foreach ($list as $fileName) {
	$filePath = './videos/'.$fileName;
	if (file_exists($filePath)){
		echo "文件已存在"."\n";
		continue;
	}

	$source = $baseURL.'/videos/'.$fileName;
	echo $fileName."\n";
 
	$ch = curl_init();//初始化一个cURL会话
	curl_setopt($ch,CURLOPT_URL,$source);//抓取url
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//是否显示头信息
	curl_setopt($ch,CURLOPT_SSLVERSION,3);//传递一个包含SSL版本的长参数
	curl_setopt($ch, CURLOPT_NOPROGRESS, false);
	curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, 'callback');
	$data = curl_exec($ch);// 执行一个cURL会话
	$error = curl_error($ch);//返回一条最近一次cURL操作明确的文本的错误信息。
	curl_close($ch);//关闭一个cURL会话并且释放所有资源
	 
	$file = fopen($filePath,"w+");
	fputs($file,$data);//写入文件
	fclose($file);
	unset($data);

	// $command = 'curl '.$source.' -o '.$filePath;
	// echo $command;
	// shell_exec();
}

function callback($resource, $downloadSize = 0, $downloaded = 0, $uploadSize = 0, $uploaded = 0){
	if ($downloadSize === 0) {
		return;
	}

	global $lastDownloaded;
	global $lastTime;

	if ($downloaded == $downloadSize) {
		printf("下载完成: %.1f%%, %.2f MB/%.2f MB\n", $downloaded/$downloadSize*100, $downloaded/1000000, $downloadSize/1000000);
		$lastDownloaded = 0;
		$lastTime = 0;
		return;
	}

	if (microtime(true)-$lastTime <= 1) {
		return;
	}

	$speed = ($downloaded-$lastDownloaded)/(microtime(true)-$lastTime)/1000;

	$lastDownloaded = $downloaded;
	$lastTime = microtime(true);


	$downloaded = $downloaded/1000000;
	$downloadSize = $downloadSize/1000000;
	
	if ($speed < 1000) {
		$speedStr = ", 下载速度：%.2f kb/s ";
	}else{
		$speedStr = ", 下载速度：%.2f mb/s ";
		$speed = $speed/1000;
	}
	printf("下载进度: %.1f%%, %.2f MB/%.2f MB".$speedStr."\r", $downloaded/$downloadSize*100, $downloaded, $downloadSize, $speed);
}

