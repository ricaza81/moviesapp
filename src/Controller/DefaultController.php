<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
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
       $url_base='https://swapi.dev/api/';
       //$response = $httpClient->request('GET','$result.url');
       //$response = $httpClient->request('GET', $url_base.'films/'.$id.'/');
       $response = $httpClient->request('GET', $url_base.'films/1');
       //$people=$response->results->characters;
       //$people=json_decode($response->getContent(), true);
       $film = json_decode($response->getContent(), true);
       //$characters = json_decode($film->getHeaders(), true);
       //$characters = $film->toArray();
       $response_character = $httpClient->request('GET', $url_base.'people/2');
       $character = json_decode($response_character->getContent(), true);
       
       foreach ($character as $character) {
           $character = json_decode($response_character->getContent(), true);
          // return $character;
        
        
        return $this->render('lucky/show_api.html.twig', array(
            'film'          => $film,
            //'people'        => $people,
            'character'     => $character,
        ));
    }
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