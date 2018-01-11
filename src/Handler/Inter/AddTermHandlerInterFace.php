<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 11/01/2018
 * Time: 23:43
 */

namespace App\Handler\Inter;


use App\Entity\Term;
use Symfony\Component\Form\FormInterface;

interface AddTermHandlerInterFace
{
    public function handle(FormInterface $form, Term $term) : bool;
}