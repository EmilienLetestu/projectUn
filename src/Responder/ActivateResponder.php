<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 14:08
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\RedirectResponse;

class ActivateResponder
{
    /**
     * @return RedirectResponse
     */
    public function __invoke($path)
    {
        return new RedirectResponse($path);
    }
}