<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 10:44
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class AdminByUserResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * AdminByUserResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $user
     * @return Response
     */
    public function __invoke($user)
    {
        return new Response(
            $this->twig->render('admin\adminUserData.html.twig',[
                'user' => $user
            ])
        );
    }
}