<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace TEST\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdvertController extends Controller
{
    public function indexAction()
    {
        return new Response("Hello World !");
    }
    // On injecte la requête dans les arguments de la méthode

    // utilisation de l'oject Response
    public function view2Action($id, Request $request)
    {
        // On récupère notre paramètre tag
        $tag = $request->query->get('tag');
        return new Response(
            "Affichage de l'annonce d'id : ".$id.", avec le tag : ".$tag
        );
    }

    // Utilisation Objet Response avec renderResponse
    public function view3Action($id, Request $request)
    {
        // On récupère notre paramètre tag
        $tag = $request->query->get('tag');

        // On utilise le raccourci : il crée un objet Response
        // Et lui donne comme contenu le contenu du template
        return $this->get('templating')->renderResponse(
            'TESTPlatformBundle:Advert:view.html.twig',
            array('id'  => $id, 'tag' => $tag)
        );
    }

    //utilisation object Response avec render seul
    public function view4Action($id, Request $request)
    {
        // On récupère notre paramètre tag
        $tag = $request->query->get('tag');

        return $this->render('TESTPlatformBundle:Advert:view.html.twig', array(
            'id'  => $id,
            'tag' => $tag,
        ));
    }

    //redirection vers une route
    public function view5Action($id)
    {
        return $this->redirectToRoute('test_platform_home');
    }

    public function view6Action($id)
    {
        // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
        $response = new Response(json_encode(array('id' => $id)));

        // Ici, nous définissons le Content-type pour dire au navigateur
        // que l'on renvoie du JSON et non du HTML
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    // Changer le content en JSON
    public function view7Action($id)
    {
        return new JsonResponse(array('id' => $id));
    }

    // SESSION
    public function view8Action($id, Request $request)
    {
        // Récupération de la session
        $session = $request->getSession();

        // On récupère le contenu de la variable user_id
        $userId = $session->get('user_id');

        // On définit une nouvelle valeur pour cette variable user_id
        $session->set('user_id', 91);

        // On n'oublie pas de renvoyer une réponse
        return new Response("<body>Je suis une page de test, je n'ai rien à dire</body>");
    }

    public function viewAction($id)
    {
        return $this->render('TESTPlatformBundle:Advert:view.html.twig', array(
            'id' => $id
        ));
    }

    // Ajoutez cette méthode :
    public function addAction(Request $request)
    {
        $session = $request->getSession();

        // Bien sûr, cette méthode devra réellement ajouter l'annonce
        // Mais faisons comme si c'était le cas
        $session->getFlashBag()->add('info', 'Annonce bien enregistrée');

        // Le « flashBag » est ce qui contient les messages flash dans la session
        // Il peut bien sûr contenir plusieurs messages :
        $session->getFlashBag()->add('info', 'Oui oui, elle est bien enregistrée !');

        // Puis on redirige vers la page de visualisation de cette annonce
        return $this->redirectToRoute('test_platform_view', array('id' => 5));

    }




}
