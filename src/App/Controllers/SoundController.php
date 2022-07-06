<?php

namespace App\Controllers;

use App\Exceptions\WrongSoundTypeException;
use App\Models\DogInterface;

class SoundController extends Controller
{
    /**
     * @return void
     * @throws WrongSoundTypeException
     */
    public function handle(): void
    {
        if (!$this->request->hasParam('sound')) {
            throw new WrongSoundTypeException('You have to provide sound type! Type help for more info.');
        }

        $sound = $this->request->getParam('sound');
        $dog = new (CONFIG['models'][$this->request->command]);

        if ($this->hasSound($dog, $sound)) {
            $this->formatter->print($dog->{$sound}());
        }
    }

    /**
     * @param  DogInterface $dog
     * @param  string       $sound
     *
     * @return bool
     * @throws WrongSoundTypeException
     */
    private function hasSound(DogInterface $dog, string $sound): bool
    {
        if (!method_exists($dog, $sound)) {
            throw new WrongSoundTypeException('Sound type not found! Type help for more info.');
        }

        return true;
    }
}
