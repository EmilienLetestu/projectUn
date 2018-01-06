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

class SearchAction
{
    private $formFactory;

    /**
     * SearchAction constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
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

            return new RedirectResponse("/browse-stories/page/1/$worldFilter/$countryFilter/$topicFilter/$patronageFilter");
        }

        return $responder();
    }
}