<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 10:24
 */

namespace App\Action\Security;


use App\Responder\Security\LoginResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginAction
{
    private $authCheck;

    /**
     * LoginAction constructor.
     * @param AuthorizationCheckerInterface $authCheck
     */
    public function  __construct(
        AuthorizationCheckerInterface $authCheck
    )
    {
        $this->authCheck  = $authCheck;
    }

    /**
     * @param AuthenticationUtils $authUtils
     * @param LoginResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(AuthenticationUtils $authUtils, LoginResponder $responder)
    {
        if($this->authCheck->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            return new RedirectResponse('/');
        }

        return $responder(
            $authUtils->getLastUsername(),
            $authUtils->getLastAuthenticationError()
        );
    }
}
