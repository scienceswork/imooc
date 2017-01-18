<?php
ini_set("memory_limit", "1024M");
require dirname(__FILE__) . '/../core/init.php';

/* Do NOT delete this comment */
/* 不要删除这段注释 */

$configs = array(
    // 爬虫名称
    'name' => '慕课网',
    // 同时工作的爬虫任务数
    'tasknum' => 8,
    // 采集失败后尝试的次数
    'max_try' => 5,
    // 导出的数据格式
    'export' => array(
        'type' => 'db',
        'table' => 'imooc',
    ),
    // 爬虫采集的域名
    'domains' => array(
        'imooc.com',
        'www.imooc.com',
    ),
    // 爬虫入口
    'scan_urls' => array(
        'http://www.imooc.com/comment/295',
    ),
    // 内容页url
    'content_url_regexes' => array(
        'http://www.imooc.com/u/\d+$',
    ),
    // 列表页url
    'list_url_regexes' => array(
        'http://www.imooc.com/course/comment/id/.*?',
        'http://www.imooc.com/comment/\d+',
        'http://www.imooc.com/wenda/.*?',
    ),
    // 定义内容以抽取规则
    'fields' => array(
        // 童鞋名称
        array(
            'name' => 'name',
            'selector' => '//*[@id="main"]/div[1]/div/h3/span',
        ),
        // 性别
        array(
            'name' => 'sex',
            'selector' => '//*[@id="main"]/div[1]/div/p[1]/span[1]/@title',
        ),
        // 学习时长
        array(
            'name' => 'time',
            'selector' => '//*[@class="u-info-learn"]/em',
        ),
        // 积分
        array(
            'name' => 'integral',
            'selector' => '//*[@id="main"]/div[1]/div/p[1]/span[3]/em',
        ),
        // 经验
        array(
            'name' => 'experience',
            'selector' => '//*[@class="u-info-mp"]/em',
        ),
        // 描述
        array(
            'name' => 'description',
            'selector' => '//*[@id="main"]/div[1]/div/p[2]',
        ),
        // 关注
        array(
            'name' => 'follow',
            'selector' => '//*[@id="main"]/div[1]/div/div/div[1]/a/em',
        ),
        // 粉丝
        array(
            'name' => 'fans',
            'selector' => '//*[@id="main"]/div[1]/div/div/div[2]/a/em',
        ),
        // 头像
        array(
            'name' => 'img',
            'selector' => '//*[@id="main"]/div[2]/div[1]/div/img/@src',
        ),
        // 用户url
        array(
            'name' => 'url',
            'selector' => '//*[@id="main"]/div[2]/div[1]/div/img', // 随便填
        )
    ),
);


$spider = new phpspider($configs);

$spider->on_start = function ($spider) {
    for ($i = 1; $i <= 200100; $i++) {
        $url = "http://www.imooc.com/u/{$i}";
        $spider->add_url($url);
    }
};

$spider->on_extract_field = function ($fieldname, $data, $page) {
    if ($fieldname == 'url') {
        $data = $page['url'];
    }

    return $data;
};

$spider->start();
