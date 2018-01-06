<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 10:25
 */

namespace App\Responder\Security;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class LoginResponder
{
    private $twig;

    /**
     * LoginResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $userName
     * @param $error
     * @return Response
     */
    public function __invoke($userName,$error)
    {
        return new Response(
            $this->twig->render('connectionForms.html.twig',[
                'last_username' =>$userName,
                'error' => $error
            ])
        );
    }
}