<?php

namespace App\Controllers;

class HelpController extends Controller
{
    public function handle(): void
    {
        $commandStorage = $this->application->getConsoleCommandStorage();

        $information = "Usage: console.php dog action\n";
        $information = $this->addAvailableDogsMessagePart($commandStorage->getDogs(), $information);
        $information = $this->addAvailableActionsMessagePart($commandStorage->getControllers(), $information);

        $this->formatter->print($information);
    }

    /**
     * @param  array  $dogs
     * @param  string $information
     *
     * @return string
     */
    private function addAvailableDogsMessagePart(array $dogs, string $information): string
    {
        $information .= "\n";
        $information .= "Available dogs:\n";

        foreach ($dogs as $dogName => $dogModel) {
            $information .= "> {$dogName}\n";
        }

        return $information;
    }

    /**
     * @param  array  $actions
     * @param  string $information
     *
     * @return string
     */
    private function addAvailableActionsMessagePart(array $actions, string $information): string
    {
        $information .= "\n";
        $information .= "Available actions:\n";

        foreach ($actions as $actionName => $actionController) {
            if ($actionName === 'sound') {
                $availableParams = implode(', ', $actionController['available_params']);
                $information .= "> {$actionName}=[{$availableParams}]\n";
            } else {
                $information .= "> {$actionName}\n";
            }
        }

        return $information;
    }
}
