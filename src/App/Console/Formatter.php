<?php

namespace App\Console;

use DateTime;

class Formatter
{
    private string $message = "";

    /**
     * @param  string $message
     *
     * @return void
     */
    public function addMessage(string $message): void
    {
        $this->message .= $message;
    }

    /**
     * @return void
     */
    public function addNewLine(): void
    {
        $this->message .= "\n";
    }

    /**
     * @return void
     */
    public function addTimestamp(): void
    {
        $date = new DateTime();
        $currentTime = $date->format('Y-m-d H:i:s');

        $this->message .= "Script finished at {$currentTime}";
    }

    /**
     * @return void
     */
    public function addSeparator(): void
    {
        $this->message .= '--------------------------------------';
    }

    /**
     * @param  string $message
     *
     * @return string
     */
    public function buildMessage(string $message): string
    {
        $this->addMessage($message);
        $this->addNewLine();
        $this->addSeparator();
        $this->addNewLine();
        $this->addTimestamp();
        $this->addNewLine();

        return $this->message;
    }

    /**
     * @param  string $message
     *
     * @return void
     */
    public function print(string $message): void
    {
        echo $this->buildMessage($message);
    }

    /**
     * @param  string $message
     *
     * @return void
     */
    public function printThrowable(string $message): void
    {
        $coloredMessage = "\033[31m{$message} \033[0m";

        echo $this->buildMessage($coloredMessage);
    }
}
