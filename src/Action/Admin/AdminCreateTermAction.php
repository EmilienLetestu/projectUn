<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 11/01/2018
 * Time: 21:33
 */

namespace App\Action\Admin;


use App\Entity\Term;
use App\Form\TermType;
use App\Responder\Admin\AdminCreateTermResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class AdminCreateTermAction
{
    private $formFactory;
    private $doctrine;
    private $urlGenerator;
    private $session;

    /**
     * AdminCreateTermAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $doctrine
     * @param UrlGeneratorInterface $urlGenerator
     * @param SessionInterface $session
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManagerInterface $doctrine,
        UrlGeneratorInterface  $urlGenerator,
        SessionInterface       $session
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->urlGenerator = $urlGenerator;
        $this->session      = $session;
    }


    /**
     * @param Request $request
     * @param AdminCreateTermResponder $responder
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminCreateTermResponder $responder)
    {
        $term = new Term();
        $form = $this->formFactory
                     ->create(TermType::class, $term)
                     ->handleRequest($request)
        ;

        if($form->isSubmitted() && $form->isValid()){
            $this->doctrine->getRepository(Term::class);
            $this->doctrine->persist($term);
            $this->doctrine->flush();

            return $this->urlGenerator
                         ->generate('adminCreateTerm')
            ;
        }

        return $responder($form->createView());
    }
}