<?php

return [
    'dogs' => [
        'plush_pug'        => \App\Models\ToyDogs\PlushPug::class,
        'poodle_with_pipe' => \App\Models\ToyDogs\PoodleWithPipe::class,
        'dachshund'        => \App\Models\RealDogs\Dachshund::class,
        'fox_terrier'      => \App\Models\RealDogs\FoxTerrier::class,
        'german_shepherd'  => \App\Models\RealDogs\GermanShepherd::class,
        'pug'              => \App\Models\RealDogs\Pug::class,
    ],

    'actions' => [
        'sound' => [
            'class'            => \App\Controllers\SoundController::class,
            'available_params' => [
                'bark',
                'squeak',
            ],
        ],
        'hunt'  => [
            'class' => \App\Controllers\HuntController::class
        ],
    ],

    'other_commands' => [
        'help' => \App\Controllers\HelpController::class
    ],

    'anonymous' => [

    ],
];
