<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 16/10/17
 * Time: 13:46
 */
namespace App\Validators;

use Symfony\Component\Validator\Constraint;


class PswdFormat extends Constraint
{
    public $message = "Le mot de passe doit contenir entre 6 et 30 caractères";

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}