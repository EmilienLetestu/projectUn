<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 16/10/17
 * Time: 17:21
 */

namespace App\Services;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class Login
{
    private $authCheck;
    private $session;
    private $token;
    private $doctrine;

    /**
     * Login constructor.
     * @param AuthorizationChecker $authCheck
     * @param Session $session
     * @param TokenStorage $token
     * @param EntityManager $doctrine
     */
    public function  __construct(
        AuthorizationChecker $authCheck,
        Session              $session,
        TokenStorage         $token,
        EntityManager        $doctrine

    )
    {
        $this->authCheck  = $authCheck;
        $this->session    = $session;
        $this->token      = $token;
        $this->doctrine   = $doctrine;
    }

    /**
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return array|string
     */
    public function processLogin(Request $request,AuthenticationUtils $authUtils)
    {
        if ( $this->authCheck->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            return $redirect = 'home';
        }

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return [
            $lastUsername,
            $error]
            ;
    }
}