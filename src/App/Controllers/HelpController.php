<?php

namespace App\Controllers;

class HelpController extends Controller
{
    public function handle(): void
    {
        $information = "Usage: console.php dog action\n";
        $information = $this->addAvailableModelsMessagePart(CONFIG['models'], $information);
        $information = $this->addAvailableActionsMessagePart(CONFIG['actions'], $information);

        $this->formatter->print($information);
    }

    /**
     * @param  array  $models
     * @param  string $information
     *
     * @return string
     */
    private function addAvailableModelsMessagePart(array $models, string $information): string
    {
        $information .= "\n";
        $information .= "Available models:\n";

        foreach ($models as $modelName => $modelClass) {
            $information .= "> {$modelName}\n";
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
