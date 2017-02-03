<?php
// src/OC/PlatformBundle/Controller/AdvertController.php

namespace TEST\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AdvertController extends Controller
{
    public function indexAction()
    {
        $content = $this
        ->get('templating')
        ->render('TESTPlatformBundle:Advert:index.html.twig',array('nom'=>'winzou'));

        return new Response($content);
    }

    public function genURLAction()
    {
        // On veut avoir l'URL de l'annonce d'id 5.

        $url = $this->get('router')->generate(

            'test_platform_view', // 1er argument : le nom de la route
            array('id' => 5)    // 2e argument : les valeurs des paramètres

        );
        // $url vaut « /platform/advert/5 »

        return new Response("L'URL de l'annonce d'id 5 est : ".$url);
    }

//    public function genURL2Action()
//    {
//        $content = $this
//        ->get('templating')
//        ->render('TESTPlatformBundle:Advert:genURL2.html.twig');
//
//        return new Response($content);
//     }




    // La route fait appel à TESTPlatformBundle:Advert:view, on doit donc définir la méthode viewAction.
    // On donne à cette méthode l'argument $id, pour correspondre au paramètre {id} de la route

    public function viewAction($id)
    {
        // $id vaut 5 si l'on a appelé l'URL /platform/advert/5
        // Ici, on récupèrera depuis la base de données
        // l'annonce correspondant à l'id $id.
        // Puis on passera l'annonce à la vue pour qu'elle puisse l'afficher

        return new Response("Affichage de l'annonce d'id : ".$id);
    }

    // On récupère tous les paramètres en arguments de la méthode
    public function viewSlugAction($slug, $year, $format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$format."."
        );
    }

    public function byeAction()
    {
        $content = $this
        ->get('templating')
        ->render('TESTPlatformBundle:Advert:bye.html.twig',array('nom'=>'winzou'));

        return new Response($content);
    }
}
