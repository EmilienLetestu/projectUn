<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 09:27
 */

namespace App\Responder\Admin;

use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AdminHomeResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * AdminHomeResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $roleEdit
     * @param $roleUser
     * @param $unactivated
     * @param $totalStory
     * @param $totalValidated
     * @param FormView $form
     * @return Response
     */
    public function __invoke($roleEdit,$roleUser,$unactivated,$totalStory,$totalValidated,FormView $form)
    {
        return new Response(
            $this->twig->render('admin\admin.html.twig',[
                'roleEdit'       => $roleEdit,
                'roleUser'       => $roleUser,
                'unactivated'    => $unactivated,
                'totalStory'     => $totalStory,
                'totalValidated' => $totalValidated,
                'form'           => $form
            ])
        );
    }
}