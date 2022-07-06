<?php

namespace App\Console;

use DateTime;
use Exception;

class Formatter
{
    private static Formatter $instance;
    private string           $message = "";

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception(get_class($this) . ' cannot be unserialized.');
    }

    /**
     * @return Formatter
     */
    public static function getInstance(): Formatter
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

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
