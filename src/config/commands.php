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
        'sound' => \App\Controllers\SoundController::class,
        'hunt'  => \App\Controllers\HuntController::class,
    ],

    'anonymous' => [
        'help' => function (\App\Console\CommandRequest $request) {
            \App\Console\Formatter::getInstance()
                ->print('Usage: console.php dog action');
        },
    ],
];
