<?php 

class Config
{
  // 91地址，可自己找免翻墙地址
  static $url = '91porn.com';
  // static $url = '627.workarea7.live';
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

}
