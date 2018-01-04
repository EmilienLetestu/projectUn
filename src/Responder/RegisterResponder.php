<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 09:42
 */

namespace App\Responder;


use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class RegisterResponder
{
  private $twig;

  /**
   * RegisterResponder constructor.
   * @param Environment $twig
   */
  public function __construct(Environment $twig)
  {
      $this->twig = $twig;
  }

  /**
   * @param FormView $form
   * @return Response
   */
  public function __invoke(FormView $form)
  {
     return new Response(
         $this->twig->render('connectionForms.html.twig',[
             'form' => $form
         ])
     );
  }
}