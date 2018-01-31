<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 14/01/2018
 * Time: 13:05
 */

namespace App\Action\Admin;


use App\Entity\Term;
use App\Form\AddLegalType;
use App\Handler\Inter\AddTermHandlerInterFace;
use App\Responder\Admin\AdminEditLegalResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminEditLegalAction
{

    private $doctrine;
    private $formFactory;
    private $session;
    private $urlGenerator;
    private $termHandler;



    /**
     * AdminEditLegalAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        FormFactoryInterface   $formFactory,
        SessionInterface       $session,
        UrlGeneratorInterface  $urlGenerator,
        AddTermHandlerInterFace $termHandler

    )
    {
        $this->doctrine     = $doctrine;
        $this->formFactory  = $formFactory;
        $this->session      = $session;
        $this->urlGenerator = $urlGenerator;
        $this->termHandler  = $termHandler;
    }


    /**
     * @param Request $request
     * @param AdminEditLegalResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminEditLegalResponder $responder)
    {
        $id = $request->attributes->get('id');

        $term = $this->doctrine
            ->getRepository(Term::class)
            ->findWithId($id)
        ;

        $form = $this->formFactory
            ->create(AddLegalType::class)
            ->handleRequest($request)
        ;

        if($this->termHandler->handle($form, $term)) {

            $this->session
                ->getFlashBag()
                ->add('success','Article has been updated')
            ;

            return new RedirectResponse(
                $this->urlGenerator
                    ->generate('adminByLegal',['id'=>$id])
            );
        }

        return $responder($term, $form->createView());
    }
}