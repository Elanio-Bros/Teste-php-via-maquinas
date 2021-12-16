<?php

namespace App\Core;

use Twig\TwigFunction;
use Twig\Extra\Intl\IntlExtension;

class Controller
{
    protected function load(string $view, $param = [], $error = null)
    {
        $twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader(relative_locate('app/view'))
        );
        $twig->addFunction(new \Twig\TwigFunction('route', function ($nameRoute) {
            $router = Routecore::getRouteName($nameRoute);
            if ($router !== false) {
                return $router;
            }
        }));
        $twig->addFunction(new \Twig\TwigFunction('ucwords', function (String $string) {
            return ucwords($string);
        }));
        
        if ($error != null) {
            $param['error'] = $error;
        }
        echo $twig->render($view . '.twig.php', $param);
    }
    protected function redirect($url, $error = null)
    {
        return header('Location: ' . $url);
    }
}
