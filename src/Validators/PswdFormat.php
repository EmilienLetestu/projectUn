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
    public $message = "Password must contains between 6 up to 30 characters";

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}

