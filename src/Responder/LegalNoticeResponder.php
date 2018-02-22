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

    /**
     * @param array $termList
     * @return Response
     */
    public function __invoke(array $termList)
    {
       return(
           new Response(
               $this->twig->render('legalNotice.html.twig',[
                   'termList' => $termList
               ])
           )
       );
    }
}
