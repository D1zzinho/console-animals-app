<?php

return [
    'controllers' => [
        'help'  => new \App\Controllers\HelpController($this),
        'sound' => new \App\Controllers\SoundController($this),
        'hunt'  => new \App\Controllers\HuntController($this)
    ],

    'anonymous' => [

    ]
];
