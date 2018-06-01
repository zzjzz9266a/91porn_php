<?php 

use Dariuszp\CliProgressBar;
class Downloader
{
	protected $bar;
	// 是否下载完成
	protected $downloaded = false;
	public function __construct()
	{
		// 初始化一个进度条
		$this->bar = new CliProgressBar(100);
		$this->bar->display();
		$this->bar->setColorToRed();
	}

	public static function download($url, $fileName, $date)
	{
		preg_replace('# #','',$fileName);
		if (!is_dir('./videos')) {
			mkdir('./videos');
		}

		$filePath = './videos/'.date('Ymd',strtotime($date)).'_'.$fileName.'.mp4';
		if (file_exists($filePath)){
			echo "文件已存在"."\n";
			return;
		}

		$header = array();
		$header[] = "User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36Name'";
		$header[] = "Referer:http://91porn.com";

		$ch = curl_init();
		// 从配置文件中获取根路径
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		// 开启进度条
		curl_setopt($ch, CURLOPT_NOPROGRESS, false);
		// 进度条的触发函数
		curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, array(new self, 'progress'));
		// ps: 如果目标网页跳转，也跟着跳转
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		$fp = fopen($filePath, 'w');
		curl_setopt($ch, CURLOPT_FILE, $fp);

		// if (false === ($stream = curl_exec($ch))) {
		// 	throw new \Exception(curl_errno($ch));
		// }
		$stream = curl_exec($ch);
		curl_close($ch);
		return $stream;
	}

	/**
	* 进度条下载.
	*
	* @param $ch
	* @param $countDownloadSize 总下载量
	* @param $currentDownloadSize 当前下载量
	* @param $countUploadSize 
	* @param $currentUploadSize
	*/
	public function progress($ch, $countDownloadSize, $currentDownloadSize, $countUploadSize, $currentUploadSize)
	{
		// 等于 0 的时候，应该是预读资源不等于0的时候即开始下载
		// 这里的每一个判断都是坑，多试试就知道了
		if (0 === $countDownloadSize) {
		return false;
		}
		// // 有时候会下载两次，第一次很小，应该是重定向下载
		// if ($countDownloadSize > $currentDownloadSize) {
		// 	$this->downloaded = false;
		// // 继续显示进度条
		// }
		// // 已经下载完成还会再发三次请求
		// elseif ($this->downloaded) {
		// 	return false;
		// }
		// // 两边相等下载完成并不一定结束，
		// elseif ($currentDownloadSize === $countDownloadSize) {
		// 	return false;
		// }

		// echo "总大小".$countDownloadSize."\n";
		// echo "已下载".$currentDownloadSize."\n";
		// 开始计算
		$this->bar->setSteps($countDownloadSize);
		$this->bar->setCurrentstep($currentDownloadSize);
		$this->bar->progress(0);
		if ($currentDownloadSize/$countDownloadSize > 0.5){
			$this->bar->setColorToYellow();
		}
		if ($currentDownloadSize/$countDownloadSize == 1){
			$this->bar->setColorToGreen();
		}
		// echo $bar;
	}
}