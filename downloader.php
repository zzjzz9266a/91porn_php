<?php 
require 'vendor/autoload.php';
require 'config.php';

class Downloader
{

	static $lastDownloaded = 0;
	static $lastTime = null;

	public static function download($url, $fileName, $date)
	{
		ini_set('memory_limit', Config::$memory_limit);	//调整最大占用内存
		$code = ['"', '*', ':', '<', '>', '？', '/', '\\', '|'];
		$fileName = preg_replace('# #','',$fileName);
		$fileName = str_replace($code, '', $fileName);
		if (!is_dir(Config::$path)) {
			mkdir(Config::$path);
		}

		$filePath = Config::$path.'/'.date('Ymd',strtotime($date)).'_'.$fileName.'.mp4';
		if (file_exists($filePath)){
			echo "\033[0;32m"."文件已存在"."\033[0m\n";
			return;
		}

		$header = array();
		$header[] = "User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36Name'";
		$header[] = "Referer:http://91porn.com";

		$ch = curl_init();
		// 从配置文件中获取根路径
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT,300);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		if (property_exists('Config', 'proxy')) {
			curl_setopt($ch, CURLOPT_PROXY, Config::$proxy);
		}
		// 开启进度条
		curl_setopt($ch, CURLOPT_NOPROGRESS, false);
		// 进度条的触发函数
		curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, array(new self, 'progress'));
		// ps: 如果目标网页跳转，也跟着跳转
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		$data = curl_exec($ch);
		curl_close($ch);
		
		if ($data) {
			$file = fopen($filePath,"w+");
			fputs($file,$data);//写入文件
			fclose($file);
		}

		// 使用rclone上传onedrive，其中“91porn:/91porn”对应网盘名称和路径
		// $command = 'rclone move -P '.$filePath.' 91porn:/91porn';
		// system($command);

		unset($data);
	}

	/**
	* 进度条下载.
	*
	* @param $ch
	* @param $downloadSize 总下载量
	* @param $downloaded 当前下载量
	* @param $uploadSize 
	* @param $uploaded
	*/
	function progress($resource, $downloadSize = 0, $downloaded = 0, $uploadSize = 0, $uploaded = 0){
		if ($downloadSize === 0) {
			return;
		}

		if ($downloaded == $downloadSize) {
			printf("下载完成: %.1f%%, %.2f MB/%.2f MB\n", $downloaded/$downloadSize*100, $downloaded/1000000, $downloadSize/1000000);
			Downloader::$lastDownloaded = 0;
			Downloader::$lastTime = 0;
			return;
		}

		if (microtime(true)-Downloader::$lastTime <= 1) {
			return;
		}

		$speed = ($downloaded-Downloader::$lastDownloaded)/(microtime(true)-Downloader::$lastTime)/1000;

		Downloader::$lastDownloaded = $downloaded;
		Downloader::$lastTime = microtime(true);

		$downloaded = $downloaded/1000000;
		$downloadSize = $downloadSize/1000000;
		
		if ($speed < 1000) {
			$speedStr = ", 下载速度：%.2f kb/s     ";
		}else{
			$speedStr = ", 下载速度：%.2f mb/s     ";
			$speed = $speed/1000;
		}
		$progress = $downloaded/$downloadSize*100;
		printf("下载进度: %.1f%%, %.2f MB/%.2f MB".$speedStr."\r", $progress, $downloaded, $downloadSize, $speed);
	}
}

function random_ip()
{
	$a = rand(0, 255);
	$b = rand(0, 255);
	$c = rand(0, 255);
	$d = rand(0, 255);
	return $a.'.'.$b.'.'.$c.'.'.$d;
}
