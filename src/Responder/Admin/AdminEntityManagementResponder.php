<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 15:31
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\RedirectResponse;

final class AdminEntityManagementResponder
{
    /**
     * @param $entity
     * @return RedirectResponse
     */
    public function __invoke($entity)
    {
        return new RedirectResponse("/admin/$entity");
    }
}