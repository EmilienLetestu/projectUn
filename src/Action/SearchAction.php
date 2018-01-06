<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 14:55
 */

namespace App\Action;


use App\Form\SearchType;
use App\Responder\SearchResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SearchAction
{
    private $formFactory;
    private $urlGenerator;

    /**
     * SearchAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        FormFactoryInterface  $formFactory,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param Request $request
     * @param SearchResponder $responder
     * @return RedirectResponse
     */
    public function __invoke(Request $request, SearchResponder $responder)
    {
        $filter = $this->formFactory
                       ->create(SearchType::class)
                       ->handleRequest($request)
        ;

        if($filter->isSubmitted() && $filter->isValid())
        {
            $country   = $filter->get('country')->getData();
            $topic     = $filter->get('topic')->getData();
            $patronage = $filter->get('patronage')->getData();
            $worldArea = $filter->get('worldArea')->getData();

            $worldFilter     = $worldArea == null ? 'all' : $worldArea;
            $countryFilter   = $country   == null ? 'all' : $country;
            $topicFilter     = $topic     == null ? 'all' : $topic->getId();
            $patronageFilter = $patronage == null ? 'all' : $patronage->getId();


            if($worldFilter === 'all' && $countryFilter === 'all' && $topicFilter === 'all' && $patronageFilter === 'all')
            {
                return $responder();
            }

            return new RedirectResponse(
                $this->urlGenerator
                     ->generate('browse',[
                         'pageNumber' => 1,
                         'worldArea'  => $worldFilter,
                         'country'    => $countryFilter,
                         'topic'      => $topicFilter,
                         'patronage'  => $patronageFilter

                     ])
            );
        }

        return $responder();
    }
}