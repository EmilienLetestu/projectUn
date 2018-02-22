<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 14/01/2018
 * Time: 13:06
 */

namespace App\Responder\Admin;


use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AdminEditLegalResponder
{
    private $twig;

    /**
     * AdminEditLegalResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $term
     * @param FormView $form
     * @return Response
     */
    public function __invoke($term, FormView $form)
    {
        return new Response(
            $this->twig->render('admin\adminEditLegal.html.twig',[
                'term' => $term,
                'form'  => $form
            ])
        );
    }
}
