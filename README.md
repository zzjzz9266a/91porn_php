<p align="center">
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://github.com/zzjzz9266a/91porn_php/blob/master/logo.jpg"></a>
</p>
  
## 使用说明：

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

下载完成后就可以到videos目录下high啦，嘿嘿嘿~~~

### 配合vps使用
有的地区91porn容易被墙，所以可以用境外的vps先下载（下载方式同上），然后再从vps下载到本地；

1、服务端由index.php提供接口，只需要把vps上的http server的监听端口指到该目录下；  
2、本地运行client_downloader.php即可下载，需要注意，此文件下的下载URL需要改成对应vps的地址。
````
$list = file_get_contents('http://ooxx.com');	//改成对应vps的域名或ip
````
