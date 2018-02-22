<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 16:59
 */

namespace App\Responder\Admin;


use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AdminPatronageResponder
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
     * @param FormView $form
     * @return Response
     */
    public function __invoke($list, FormView $form)
    {
        return new Response(
            $this->twig->render('admin\adminPatronage.html.twig',[
                'patronageList' => $list,
                'form'          => $form
            ])
        );
    }
}
