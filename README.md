<p align="center">
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://github.com/zzjzz9266a/91porn_php/blob/master/logo.jpg?v=2"></a>
</p>

<p align="center">
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/badge/platform-all-lightgrey.svg"></a>
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/apm/l/vim-mode.svg"></a>
    <a href="https://github.com/zzjzz9266a/91porn_php"><img src="https://img.shields.io/badge/language-php>=%205.6-orange.svg"></a>
</p>

  
## 使用说明
### 基本使用
所有的配置项都在 `Config.php` 文件里，根据需要自行更改：

* 91的主站地址：  

``` php
static $url = '91porn.com';
// static $url = '627.workarea7.live';  //免翻墙地址
// static $url = 'e528.mbaudet.cl';
```

* 视频存放路径，默认放在项目的`videos`文件夹下
``` php
static $path = __DIR__.'/videos';
// static $path = '/Users/ooxx/Downloads/videos';
```

* 代理（**推荐**），可支持`http`代理或`socks5`代理
``` php
// static $proxy = 'http://127.0.0.1:1087';
// static $proxy = 'socks5://127.0.0.1:1086';
```

* 运行91all.php需要下载的列表地址以及页码数(只需要提取 "?" 以后的内容)
``` php
static $all_lists = [
  'category=top&viewtype=basic' => [1, 10],     //本月最热
  'category=mf&viewtype=basic' => [1, 5],       //收藏最多
  'category=md&viewtype=basic' => 4,            //收藏最多
];
```

* 内存限制，越大越好
``` php
static $memory_limit = '512M';
```

### 批量下载视频
首页：
````
php 91porn.php
````
列表页：
````
php 91all.php
````

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
