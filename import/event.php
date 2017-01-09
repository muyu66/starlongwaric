<?php

return [
    // 普通事件
    'normal' => [
        [
            'name' => '遭遇战',
            'desc' => '遭遇战',
            'event' => 1,
            'params' => ['count' => 1],
        ],
        [
            'name' => '遭遇小规模舰队',
            'desc' => '遭遇小规模舰队',
            'event' => 1,
            'params' => ['count' => 3],
        ],
        [
            'name' => '遭遇大规模舰队',
            'desc' => '遭遇大规模舰队',
            'event' => 1,
            'params' => ['count' => 5],
        ],
        [
            'name' => '招募船员',
            'desc' => '前往酒馆招募到初级船员',
            'event' => 2,
            'params' => ['level' => 30],
        ],
    ],
];