<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 16:59
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class AdminPatronageResponder
{
    private $twig;

    /**
     * AdminPatronageResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $list
     * @param $form
     * @return Response
     */
    public function __invoke($list, $form)
    {
        return new Response(
            $this->twig->render('admin\adminPatronage.html.twig',[
                'patronageList' => $list,
                'form'          => $form
            ])
        );
    }
}