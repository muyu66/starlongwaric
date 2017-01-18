<?php

return [
    'initGalaxy' => [
        [
            'id' => 1,
            'name' => '银河系',
            'coordinate' => ['x' => 323, 'y' => 144],
        ]
    ],
    'initQuadrant' => [
        [
            'id' => 1,
            'galaxy_id' => 1,
            'name' => 'Alpha象限',
            'coordinate' => ['x' => 323000, 'y' => 144250],
        ],
        [
            'id' => 2,
            'galaxy_id' => 1,
            'name' => 'Beta象限',
            'coordinate' => ['x' => 323251, 'y' => 144500],
        ],
        [
            'id' => 3,
            'galaxy_id' => 1,
            'name' => 'Gamma象限',
            'coordinate' => ['x' => 323501, 'y' => 144750],
        ],
        [
            'id' => 4,
            'galaxy_id' => 1,
            'name' => 'Delta象限',
            'coordinate' => ['x' => 323751, 'y' => 144999],
        ],
    ],
    'initPlanet' => [
        [
            'id' => 1,
            'quadrant_id' => 1,
            'name' => '地球',
            'coordinate' => ['x' => 323751254, 'y' => 144999365],
        ]
    ],
];
