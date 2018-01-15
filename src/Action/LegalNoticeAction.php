<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 15/01/2018
 * Time: 08:43
 */

namespace App\Action;


use App\Responder\LegalNoticeResponder;

class LegalNoticeAction
{
    public function __invoke(LegalNoticeResponder $responder)
    {
        return($responder());
    }
}