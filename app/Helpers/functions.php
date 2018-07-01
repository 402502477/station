<?php
//record logs type
const LOG_TYPE_NORMAL = 1;
const LOG_TYPE_WARNING = 2;
const LOG_TYPE_DANGER = 3;


/**
 * record system operate to the logs table
 * @param string $title
 * @param int $type 1 normal message 2 warning message 3 danger message
 * @param array|null $info
 * @param array|null $extend
 * @return mixed
 */
function add_service_log(string $title, int $type, array $info = null, array $extend = null)
{
    $data = [
        'log_id' => date('YmdHis',time()).rand(100000,999999),
        'title' => $title,
        'info' => json_encode($info),
        'extend' => json_encode($extend),
        'type' => $type
    ];

    $res = \App\Model\Logs::create($data);
    return $res;
}