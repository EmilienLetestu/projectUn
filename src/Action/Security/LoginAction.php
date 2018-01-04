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
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginAction
{
    private $authCheck;

    /**
     * LoginAction constructor.
     * @param AuthorizationChecker $authCheck
     */
    public function  __construct(
        AuthorizationChecker $authCheck
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