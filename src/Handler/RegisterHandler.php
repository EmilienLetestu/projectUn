<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 19:36
 */

namespace App\Handler;


use App\Entity\User;
use App\Handler\Inter\RegisterHandlerInterface;
use App\Services\Mail;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RegisterHandler implements RegisterHandlerInterface
{
   private $mailService;
   private $session;

    /**
     * RegisterHandler constructor.
     * @param Mail $mailService
     * @param SessionInterface $session
     */
   public function __construct(
       Mail $mailService,
       SessionInterface $session

   )
   {
       $this->mailService = $mailService;
       $this->session     = $session;
   }

    /**
     * @param FormInterface $form
     * @param User $user
     * @return mixed
     */
   public function handle(FormInterface $form, User $user)
   {
       if($form->isSubmitted() && $form->isValid())
       {
           $emailInDb = $this->mailService
               ->checkMailAvailability($user->getEmail())
           ;

           if ($emailInDb !== null) {
               $this->session
                   ->getFlashBag()
                   ->add('denied', 'This email is already used')
               ;
               return false;
           }

           //hydrate with submitted data
           $user->setRegisteredOn('Y-m-d');
           $user->setRole('user');
           $user->setConfirmationToken(40);
           $form->get('claimEdit')->getData() == true ?
               $user->setBeenProcessed(false) :
               $user->setBeenProcessed(true)
           ;

           //prepare email
           $message = $this->mailService->validationMail(
               $user->getName(),
               $user->getSurname(),
               $user->getConfirmationToken(),
               $user->getEmail(),
               "activation@climateStories.com"
           );

           $this->session
               ->getFlashBag()
               ->add('success', 'Account created ! An activation email has been sent to you ')
           ;

           return $message;
       }
       return false;
   }
}