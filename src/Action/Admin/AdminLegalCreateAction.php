<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 11/01/2018
 * Time: 21:33
 */

namespace App\Action\Admin;


use App\Entity\Term;
use App\Form\AddLegalType;
use App\Handler\Inter\AddTermHandlerInterFace;
use App\Responder\Admin\AdminLegalCreateResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class AdminLegalCreateAction
{
    private $formFactory;
    private $urlGenerator;
    private $session;
    private $termHandler;


    /**
     * AdminLegalCreateAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     * @param SessionInterface $session
     * @param AddTermHandlerInterFace $termHandler
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        UrlGeneratorInterface  $urlGenerator,
        SessionInterface       $session,
        AddTermHandlerInterFace $termHandler

    )
    {
        $this->formFactory  = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->session      = $session;
        $this->termHandler  = $termHandler;
    }


    /**
     * @param Request $request
     * @param AdminLegalCreateResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminLegalCreateResponder $responder)
    {
        $term = new Term();

        $form = $this->formFactory
                     ->create(AddLegalType::class)
                     ->handleRequest($request)
        ;

        $handler =$this->termHandler->handle($form, $term);

        if($handler)
        {
            $this->session->getFlashBag()->add('success','Legal notice saved');
            return new RedirectResponse(
                $this->urlGenerator
                     ->generate('adminLegal')
            );
        }
        return $responder($form->createView());
    }
}
