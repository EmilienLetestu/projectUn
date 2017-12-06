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
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class Login
{
    private $authCheck;

    /**
     * Login constructor.
     * @param AuthorizationChecker $authCheck
     */
    public function  __construct(AuthorizationChecker $authCheck)
    {
        $this->authCheck  = $authCheck;
    }

    /**
     * @param AuthenticationUtils $authUtils
     * @return array|string
     */
    public function processLogin(AuthenticationUtils $authUtils)
    {
        if ( $this->authCheck->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            return 'home';
        }

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return [
            $lastUsername,
            $error
        ];
    }
}
