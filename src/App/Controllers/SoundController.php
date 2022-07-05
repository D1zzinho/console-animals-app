<?php

namespace App\Controllers;

use App\Exceptions\WrongSoundTypeException;

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

        if ($this->hasSound($sound)) {
            $this->formatter->print($this->dog->{$sound}());
        }
    }

    /**
     * @param  string $sound
     *
     * @return bool
     * @throws WrongSoundTypeException
     */
    private function hasSound(string $sound): bool
    {
        if (!method_exists($this->dog, $sound)) {
            throw new WrongSoundTypeException('Sound type not found! Type help for more info.');
        }

        return true;
    }
}
