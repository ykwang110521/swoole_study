<?php
swoole_timer_tick(1000, function(){
    echo "这是一条定时消息".rand(1,999).'---'.date('Y-m-d H:i:s')."\n";

});

//3000ms后执行此函数
swoole_timer_after(3000, function () {
    echo "after 3000ms.\n";
});