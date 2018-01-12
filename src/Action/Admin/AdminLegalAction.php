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
use App\Responder\Admin\AdminLegalResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class AdminLegalAction
{
    private $formFactory;
    private $urlGenerator;
    private $session;
    private $termHandler;

    /**
     * AdminCreateTermAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     * @param SessionInterface $session
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
     * @param AdminLegalResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminLegalResponder $responder)
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