<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 29/10/2017
 * Time: 04:44
 */

namespace App\Validators;
use Symfony\Component\Validator\Constraint;

class WordLimit extends Constraint
{
    public $limit;
    public $message = 'This text is limited to ';

    public function __construct($options)
    {
       if($options !== null)
       {
           $this->limit = $options['limit'];
       }
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}

