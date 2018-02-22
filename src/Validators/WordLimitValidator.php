<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 29/10/2017
 * Time: 04:49
 */

namespace App\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WordLimitValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $count = str_word_count(strip_tags($value));
        $limit = $constraint->getLimit();
        if($count > $limit)
        {
            $this->context->buildViolation($constraint->message.$limit.' words'.$count)
                ->addViolation()
            ;
        }

    }
}

