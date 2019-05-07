<p align="center">
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://github.com/zzjzz9266a/91porn_php/blob/master/logo.jpg"></a>
</p>

<p align="center">
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/badge/platform-all-lightgrey.svg"></a>
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/apm/l/vim-mode.svg"></a>
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/badge/language-php>=%205.6-orange.svg"></a>
</p>

  
## 使用说明
[使用教程](https://github.com/zzjzz9266a/91porn_php/wiki/Aria2%E7%89%88%E4%BD%BF%E7%94%A8%E6%8C%87%E5%8D%97)

* 用aria2进行下载，速度与稳定性都大幅提升，需要安装 [`aria2`](https://github.com/aria2/aria2)，配合 [`webUI`](https://github.com/mayswind/AriaNg) 体验更佳

* 建议配合代理使用，理论上可以跑满带宽

* 另有docker镜像 [`91porn-crawler`](https://github.com/zzjzz9266a/91porn-docker)一键安装，无需配置任何环境，教程参照 [`Docker版简明使用指南`](https://github.com/zzjzz9266a/91porn_php/wiki/Docker%E7%89%88%E7%AE%80%E6%98%8E%E4%BD%BF%E7%94%A8%E6%8C%87%E5%8D%97)

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
下载完成后就可以到videos目录下找到视频文件了


### 下载单个视频文件
运行`detailPage.php`文件，将视频网页的地址传入
````
php detailPage.php http://91porn.com/view_video.php?viewkey=042a30e56c9cd20b075f
````

* windows, linux, macos
* php >= 5.6
* aria2
* nodejs
