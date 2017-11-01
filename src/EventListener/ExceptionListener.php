<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 01/11/2017
 * Time: 10:41
 */
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;


class ExceptionListener
{

    private $twig;

    /**
     * ExceptionListener constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * catch errors and display custom template
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $response = new Response();

        if($exception instanceof HttpExceptionInterface && $exception->getStatusCode() === 404)
        {
            $template = $this->twig->render('error.html.twig',[
               'message'=>'This page doesn\'t exist yet !',
            ]);
            $response->setContent($template);
        }

       else {
            $template = $this->twig->render('error.html.twig',[
                'message' => 'We are experiencing technical issues, please try again later on.',
            ]);
            $response->setContent($template);
        }

        $event->setResponse($response);
    }
}

