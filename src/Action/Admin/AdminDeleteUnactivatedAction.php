<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 14:20
 */

namespace App\Action\Admin;


use App\Managers\UserManager;
use App\Responder\Admin\AdminDeleteUnactivatedResponder;

class AdminDeleteUnactivatedAction
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * AdminDeleteUnactivatedAction constructor.
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param AdminDeleteUnactivatedResponder $responder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(AdminDeleteUnactivatedResponder $responder)
    {
        $this->userManager->deleteAllUnactivatedAccount(' - 60 day');

        return $responder();
    }
}