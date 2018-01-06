<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 15:28
 */

namespace App\Action\Admin;


use App\Managers\StoryManager;
use App\Managers\UserManager;
use App\Responder\Admin\AdminEntityManagementResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminEntityManagementAction
{

   private $userManager;
   private $storyManager;
   private $session;

   /**
    * AdminEntityManagementAction constructor.
    * @param UserManager $userManager
    * @param StoryManager $storyManager
    * @param Session $session
    */
   public function __construct(
       UserManager  $userManager,
       StoryManager $storyManager,
       Session      $session
   )
   {
       $this->userManager  = $userManager;
       $this->storyManager = $storyManager;
       $this->session      = $session;
   }

   /**
    * @param Request $request
    * @param AdminEntityManagementResponder $responder
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
   public function __invoke(Request $request, AdminEntityManagementResponder $responder)
   {
       $entity = $request->attributes->get('entity');
       $action = $request->attributes->get('action');

       $method = $action.ucfirst($entity);

       $entity === 'story' ?
           $process = $this->storyManager
               ->$method($request->attributes->get('id'))
           :
           $process = $this->userManager
               ->$method($request->attributes->get('id'))
       ;

       $this->session->getFlashBag()->add('success',$process);

       return $responder($entity);
   }
}