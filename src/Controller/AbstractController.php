<?php

namespace App\Controller;

abstract class AbstractController
{

    private const TEMPLATE_DIR = __DIR__.'/../../view';

    /**
     * @throws \Exception
     */
    public function render(string $template, array $parameters = []): string
    {
        $templateFile = self::TEMPLATE_DIR.'/'.$template;

        if (!file_exists($templateFile)) {
            throw new \Exception(sprintf('No view found to render "%s"', $template));
        }

        // Import variables to access in the view
        // Example transform ['name' => 'toto', 'message' => 'Hello'] to $name = 'toto'; $message = 'Hello';
        // https://www.php.net/manual/fr/function.extract.php
        extract($parameters);

        return require self::TEMPLATE_DIR.'/'.$template;
    }

    public function redirectToUrl(string $url, array $parameters = []): void
    {
        $query = http_build_query($parameters);

        header('Location: '.$url.'?'.$query);
    }
    public function render404(): void {
        include '../views/404.php';
        exit();
    }
}