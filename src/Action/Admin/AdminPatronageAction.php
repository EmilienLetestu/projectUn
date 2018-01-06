<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 16:58
 */

namespace App\Action\Admin;


use App\Entity\Patronage;
use App\Responder\Admin\AdminPatronageResponder;
use App\Services\EditPatronage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminPatronageAction
{
    private $doctrine;
    private $editPatronage;
    private $session;
    private $urlGenerator;

    /**
     * AdminPatronageAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param EditPatronage $editPatronage
     * @param SessionInterface $session
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        EditPatronage          $editPatronage,
        SessionInterface       $session,
        UrlGeneratorInterface  $urlGenerator
    )
    {
      $this->doctrine      = $doctrine;
      $this->editPatronage = $editPatronage;
      $this->session       = $session;
      $this->urlGenerator  = $urlGenerator;
    }

    /**
     * @param Request $request
     * @param AdminPatronageResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminPatronageResponder $responder)
    {
        $repository = $this->doctrine->getRepository(Patronage::class);

        $form = $this->editPatronage->processPatronage($request);

        if($this->session->get('added')){
            $this->session->remove('added');
            return new RedirectResponse(
                $this->urlGenerator
                     ->generate('adminPatronage')
            );
        }

       return $responder($repository->findAll(),$form);
    }
}
