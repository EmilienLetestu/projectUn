<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 14:26
 */

namespace App\Responder;

use Symfony\Component\HttpFoundation\RedirectResponse;

final class AdminDeleteUnactivatedResponder
{
    /**
     * @return RedirectResponse
     */
    public function __invoke()
    {
        return new RedirectResponse('/admin');
    }
}