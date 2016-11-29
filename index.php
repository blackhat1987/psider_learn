<?php
include 'simple_html_dom.php';

$url = 'http://www.dbmeinv.com/';
$limit = 20;
$c = 0;//图片总数
$html= new simple_html_dom();

if (!file_exists(__DIR__.'/image')) {
    mkdir(__DIR__.'/image');
};

echo "please wait...";

//todo fix url 
for ($i = 0; $i<$limit;$i++ ) {
    $result = newPage($url);
    file_put_contents(__DIR__.'/simple.html',$result);
    $html->load_file(__DIR__.'/simple.html');
    $ul = $html
        ->find('#main',0)
        ->find('div[class=panel-body]',1)
        ->find('ul[class=thumbnails]',0)
        ->find('li');
    foreach ($ul as $li) {
        $img = file_get_contents($li->find('img',0)->src);
        file_put_contents(__DIR__.'/image/'.$c.'.jpg',$img);
        ++$c;
    }
    $html->clear();
    unlink(__DIR__.'/simple.html');
}

echo "finished";



function newPage($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}