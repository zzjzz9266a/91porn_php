<?php 

class Config
{
  // 91地址，可自己找免翻墙地址
  // static $url = '91porn.com';
  static $url = '627.workarea7.live';
  // static $url = 'e528.mbaudet.cl';

  // 视频存放路径
  static $path = __DIR__.'/videos';
  // static $path = '/Users/ooxx/Downloads/videos';

  // 代理
  // static $proxy = 'http://127.0.0.1:1087';
  // static $proxy = 'socks5://127.0.0.1:1086';

  // 运行91all.php需要下载的列表地址以及页码数(只需要提取 "?" 以后的内容)
  static $all_lists = [
    'category=top&viewtype=basic' => [1, 10],     //本月最热
    'category=mf&viewtype=basic' => [1, 5],       //收藏最多
    'category=md&viewtype=basic' => 4,            //收藏最多
  ];

  // 内存限制，越大越好
  static $memory_limit = '512M';

  static $cookie = "__cfduid=dd11a37f7baef4adc85d4b9062ca231a61565688957; cf_clearance=3ca2b7bb86987727980c1319f440c766458c98ee-1565688962-1800-150; __utma=112696451.544816386.1565688963.1565688963.1565688963.1; __utmb=112696451.0.10.1565688963; __utmc=112696451; __utmz=112696451.1565688963.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)";

  static $user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36";
}
