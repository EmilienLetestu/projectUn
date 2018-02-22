<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 15:28
 */

namespace App\Action\Admin;


use App\Managers\StoryManager;
use App\Managers\TermManager;
use App\Managers\UserManager;
use App\Responder\Admin\AdminEntityManagementResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AdminEntityManagementAction
{

   private $userManager;
   private $storyManager;
   private $termManager;
   private $session;

    /**
     * AdminEntityManagementAction constructor.
     * @param UserManager $userManager
     * @param StoryManager $storyManager
     * @param TermManager $termManager
     * @param SessionInterface $session
     */
   public function __construct(
       UserManager      $userManager,
       StoryManager     $storyManager,
       TermManager      $termManager,
       SessionInterface $session
   )
   {
       $this->userManager  = $userManager;
       $this->storyManager = $storyManager;
       $this->termManager  = $termManager;
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
       $id     = $request->attributes->get('id');

       $method = $action.ucfirst($entity);
       $manager = $entity.'Manager';

       $process = $this->$manager->$method($id);

       $this->session->getFlashBag()->add('success',$process);

       return $responder($entity === 'term' ? 'legal' : $entity);
   }
}
