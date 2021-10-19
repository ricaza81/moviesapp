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

class PeopleController extends AbstractController
{
    public function index(Request $request)
    {
        //$em = $this->getDoctrine()->getManager();
        //$films = $em->getRepository('App:Film')->findAll();
        $httpClient = HttpClient::create();
        $response1 = $httpClient->request('GET', 'https://swapi.dev/api/people');
        $response = json_decode($response1->getContent(), true);
        $responses =[];
        //$content = $response->getContent();
        if (200 !== $response1->getStatusCode()) {
            // handle the HTTP request error (e.g. retry the request)
            } else {
            $headers = $response1->getHeaders();
            $content = $response1->getContent();
            }
              return $this->render('people/index.html.twig',
                [
                    'headers' => $headers,
                    'response' => $response,
                    //'response' => getResult($response),
                    'content' => $content,
          //          'films' => $films,
                ]
                );
    }

      /**
     * Finds and displays a film entity api.
     *
     */
     public function showActionApi():Response
    {
       $em = $this->getDoctrine()->getManager();
       $film = $em->getRepository('App:Film')->find(4); 
       $httpClient = HttpClient::create();
       $url_base='https://swapi.dev/api/';
       $response = $httpClient->request('GET', $url_base.'films/1');
       $film_api = json_decode($response->getContent(), true);
       //$film_api = json_decode($response->getContent(), true);
       /*[
        'characters' => $response,
       ]
       );
       dd($film_api);*/
      // $title = json_decode($response->getContent(array $film_api), true);
      // $people = $film_api->$characters;
       //$url_characters = [ 'url_characters' => $film($results) ];
       $response_character = $httpClient->request('GET', $url_base.'people/');
       //$character = json_decode($response_character->getContent($film_api=true));
       $character = json_decode($response_character->getContent(), true);

       //Endpoint in endpoint//
       //$film_endpoint = json_decode($response->getContent(), true);
       $film_endpoint=$httpClient->request('GET', $url_base.'films/1');
       //foreach ($film_endpoint as $fl) {
       //    $fl = json_decode($film_endpoint->getContent(), true);
       //  };
       //  return ($fl);
        //Endpoint in endpoint//

        return $this->render('lucky/show_api.html.twig', array(
            'film_api'  => $film_api,
            'film'      => $film,
            'character' => $character,
            'response_character' => $response_character,
        //    'fl'        => $fl,
        ));
    //}
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