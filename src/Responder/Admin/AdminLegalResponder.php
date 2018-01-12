<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 12/01/2018
 * Time: 07:18
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AdminLegalResponder
{
    private $twig;

    /**
     * AdminLegalResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    public function __invoke(array $legalList)
    {
        return new Response(
            $this->twig->render('admin\adminLegal.html.twig',[
                'legalList' => $legalList
            ])
        );
    }
}