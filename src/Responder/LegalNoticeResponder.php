<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 15/01/2018
 * Time: 08:44
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class LegalNoticeResponder
{
    private  $twig;

    /**
     * LegalNoticeResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke()
    {
       return(
           new Response($this->twig->render('legalNotice.html.twig'))
       );
    }
}