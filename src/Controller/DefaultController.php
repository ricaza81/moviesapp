<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Film;
use App\Entity\Persons;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
//use Doctrine\ORM\Mapping\ClassMetadata;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $films = $em->getRepository('App:Film')->findAll();
        $httpClient = HttpClient::create();
        $response1 = $httpClient->request('GET', 'https://swapi.dev/api/films');
        $response = json_decode($response1->getContent(), true);
        $responses =[];
        //$content = $response->getContent();
        if (200 !== $response1->getStatusCode()) {
            // handle the HTTP request error (e.g. retry the request)
            } else {
            $headers = $response1->getHeaders();
            $content = $response1->getContent();
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
    }

      /**
     * Finds and displays a film entity api.
     *
     */
     public function showActionApi():Response
    {
       $httpClient = HttpClient::create();
       //$response = $httpClient->request('GET','$result.url');
       $response = $httpClient->request('GET', 'https://swapi.dev/api/films/1/');
       $film = json_decode($response->getContent(), true);

        return $this->render('lucky/show_api.html.twig', array(
            'film' => $film,
        ));
    }

     /**
     * Finds and displays a film entity.
     *
     */
     public function showAction($id):Response
    {
        //$deleteForm = $this->createDeleteForm($film);
        $film = $this->getDoctrine()->getManager()
        ->getRepository('App:Film')
        ->find($id);

        return $this->render('lucky/show.html.twig', array(
            'film' => $film,
        //    'delete_form' => $deleteForm->createView(),
        ));
    }

    
}