<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Film;
use App\Entity\Persons;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $films = $em->getRepository('App:Film')->findAll();
       // $filmslist = $this->getDoctrine()->getRepository('App:Film');
       // $films  = $this->get('knp_paginator')->paginate(
       //     $filmslist,
        //    $request->query->get('page', 1)/*page number*/,
        //    3/*limit per page*/
        //    );

        $httpClient = HttpClient::create();
        //$response = $httpClient->request('GET', 'https://swapi.dev/api/people/1/');
        $response1 = $httpClient->request('GET', 'https://swapi.dev/api/films/1/');
        $response = json_decode($response1->getContent());
        $responses =[];
        //$content = $response->getContent();
        if (200 !== $response1->getStatusCode()) {
            // handle the HTTP request error (e.g. retry the request)
            } else {
            $headers = $response1->getHeaders();
            $content = $response1->getContent();
            foreach ($httpClient->stream($responses) as $response => $chunk) 
            {
                $title=$chunk->title;
            }
            }
              return $this->render('lucky/number.html.twig',
                [
                    'headers' => $headers,
                    'response' => $response,
                    //'response' => getResult($response),
                    'content' => $content,
                    'films' => $films,
                ]
                );

        //return $this->render('film/index.html.twig', array(
        //    'films' => $films,
        //));
    }
}