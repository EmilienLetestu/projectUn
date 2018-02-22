<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 14:55
 */

namespace App\Responder;

use Symfony\Component\HttpFoundation\RedirectResponse;
class SearchResponder
{
    /**
     * @return RedirectResponse
     */
    public function __invoke()
    {
        return new RedirectResponse("/browse-stories/page/1");
    }
}
