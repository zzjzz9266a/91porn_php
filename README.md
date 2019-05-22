<p align="center">
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://github.com/zzjzz9266a/91porn_php/blob/master/logo.jpg?v=2"></a>
</p>

<p align="center">
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/badge/platform-all-lightgrey.svg"></a>
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/apm/l/vim-mode.svg"></a>
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/badge/language-php>=%205.6-orange.svg"></a>
</p>

  
## 使用说明

* 新增使用代理入口：`downloader.php`第12行，请自行选择

* 当前版本的下载机制是先下到内存里，再存到磁盘上，以防止下载中断导致文件不完整。所以请调整`downloader.php`中内存的限制，保守起见最好在`512mb`以上，否则有可能出现内存不够而退出

````
ini_set('memory_limit','2048M');	//调整最大占用内存
````

如果需要不占用内存的版本，请下载<a href="https://github.com/zzjzz9266a/91porn_php/releases/tag/v1.0.0">v1.0.0</a>

### 基本使用
`91porn.php`是爬取首页的视频，直接运行即可

`91all.php`是爬取列表页的，例如“收藏最多”、“本月最热”等等，要别的列表的话可以去找对应的url
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
下载完成后就可以到videos目录下找到视频文件了

### 使用代理
在`downloader.php`中修改代理地址：
```
// static $proxy = 'http://127.0.0.1:1087';
// static $proxy = 'socks5://127.0.0.1:1086';
```
可支持`http`代理或`socks5`代理，稳定性更高

### 下载单个视频文件
运行`detailPage.php`文件，将视频网页的地址传入
````
php detailPage.php http://91porn.com/view_video.php?viewkey=042a30e56c9cd20b075f
````

## 环境要求
* windows, linux, macos
* nodejs
* php >= 5.6

### Node.js 安装方法：
#### Windows
https://nodejs.org/en/download/
#### MacOS
`brew install node --with-npm`
#### 群晖
套件中心
#### CentOS
`yum install nodejs`
#### Ubuntu
`apt-get install nodejs`

## 联系方式
![](https://zzjtemp.oss-cn-beijing.aliyuncs.com/%E5%A4%A7%E8%B4%A7%E5%8F%B8%E6%9C%BA%E8%BD%A6%E6%8A%80%E4%BA%A4%E6%B5%81%E7%BE%A4%E7%BE%A4%E4%BA%8C%E7%BB%B4%E7%A0%81.png?v=5&Expires=1558497674&OSSAccessKeyId=TMP.AgGPwASm1-bpl4bX7Za58nzk8RGLB4-5AdnKPDXrDa161ng0XZoyqZJHQ7qaMC4CFQCoFMt-Epqoob1XhXW4zZPk7gpI3AIVAKIqgSyl8uq_Tq4HDsU1oT_n56c_&Signature=koXzQIRfWBt1jANj845ezeLxQAQ%3D)
