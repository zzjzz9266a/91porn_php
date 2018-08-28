<p align="center">
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://github.com/zzjzz9266a/91porn_php/blob/master/logo.jpg"></a>
</p>

<p align="center">
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/badge/platform-all-lightgrey.svg"></a>
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/apm/l/vim-mode.svg"></a>
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/badge/language-php>=%205.6-orange.svg"></a>
</p>
  
## 使用说明
当前版本的下载机制是先下到内存里，再存到磁盘上，以防止下载中断导致文件不完整。所以请调整downloader.php中内存的限制，最好在256mb以上，否则有可能出现内存溢出。  
````
ini_set('memory_limit','2048M');	//调整最大占用内存
````

如果需要不占用内存的版本，请下载<a href="https://github.com/zzjzz9266a/91porn_php/releases/tag/v1.0.0">v1.0.0</a>

### 基本使用
91porn.php是爬取首页的视频，直接运行即可

91all.php是爬取列表页的，例如“收藏最多”、“本月最热”等等，要别的列表的话可以去找对应的url
```` php
listPage("http://91porn.com/v.php?category=top&viewtype=basic");	//本月最热
listPage("http://91porn.com/v.php?category=mf&viewtype=basic");		//收藏最多
listPage("http://91porn.com/v.php?category=md&viewtype=basic");		//本月讨论
````
爬取页数可以自行更改，默认到10页；
````
$maxPage = 10;	//更改爬取页数
````
可以在downloader.php中更改视频的默认存放路径：
````
static $defaultPath = './videos';	//默认储存路径
````

下载完成后就可以到videos目录下high啦，嘿嘿嘿~~~

### 配合vps使用
有的地区91porn容易被墙，所以可以用境外的vps先下载（下载方式同上，而且境外vps下载速度极快），然后再从vps下载到本地；

1、服务端由index.php提供接口，只需要把vps上的http server的监听端口指到该目录下；  
2、本地运行client_downloader.php即可下载，需要注意，此文件下的下载URL需要改成对应vps的地址。
````
$baseURL = 'http://xxoo.com';	//改成对应vps的域名或ip
````

## 环境要求

* windows, linux
* php >= 5.6

## 参与开源

欢迎提交 issue 和 PR，大门永远向所有人敞开。

## 开源协议

本项目遵循 MIT 协议开源，具体请查看根目录下的 LICENSE 文件。
