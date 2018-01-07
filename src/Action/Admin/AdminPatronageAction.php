<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 16:58
 */

namespace App\Action\Admin;


use App\Entity\Patronage;
use App\Form\EditPatronageType;
use App\Handler\Inter\EditPatronageHandlerInterface;
use App\Responder\Admin\AdminPatronageResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminPatronageAction
{
    private $doctrine;
    private $urlGenerator;
    private $editPatronageHandler;
    private $formFactory;

    /**
     * AdminPatronageAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param UrlGeneratorInterface $urlGenerator
     * @param EditPatronageHandlerInterface $editPatronageHandler
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        EntityManagerInterface        $doctrine,
        UrlGeneratorInterface         $urlGenerator,
        EditPatronageHandlerInterface $editPatronageHandler,
        FormFactoryInterface          $formFactory
    )
    {
      $this->doctrine             = $doctrine;
      $this->urlGenerator         = $urlGenerator;
      $this->editPatronageHandler = $editPatronageHandler;
      $this->formFactory          = $formFactory;
    }

    /**
     * @param Request $request
     * @param AdminPatronageResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminPatronageResponder $responder)
    {
        $repository = $this->doctrine->getRepository(Patronage::class);

        $form = $this->formFactory
                     ->create(EditPatronageType::class)
                     ->handleRequest($request)
        ;
        $patronage = new Patronage();

        if($this->editPatronageHandler->handle($form,$patronage)){
            return new RedirectResponse(
                $this->urlGenerator
                     ->generate('adminPatronage')
            );
        }

       return $responder(
           $repository->findAll(),
           $form->createView()
       );
    }
}
