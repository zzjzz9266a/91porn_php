# 91porn_php
91爬虫php版本

#### 2018.6.4更新：

由于91porn容易被墙，所以建议用境外的vps先下载，然后再从vps下载到本地；

由index.php提供接口，只需要把vps上的http server指到该目录下即可，然后在本地用client_downloader.php下载

----

91porn.php是爬取91首页的视频；

91all.php是列表页的，例如“收藏最多”、“本月最热”等等，要别的排序的话自己去找url，爬取页数自己改，默认到10页；

暂不用composer了，因为我改了依赖库，didom原先没有加header的功能
