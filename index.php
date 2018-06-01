<?php

$list = scandir('./videos');
foreach( $list as $k=>$v) {
 if (('.' == $v) || ('..' == $v)) unset($list[$k]);
}
$list = array_merge($list);

echo json_encode($list);