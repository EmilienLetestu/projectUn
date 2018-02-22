<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 12/01/2018
 * Time: 08:02
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AdminByLegalResponder
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
     * @param $term
     * @return Response
     */
    public function __invoke($term)
    {
        return new Response(
            $this->twig->render('admin\adminLegalData.html.twig',[
                'term' => $term
            ])
        );
    }
}
