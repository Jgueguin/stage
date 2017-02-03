<?php
// src/OC/PlatformBundle/Controller/AdvertController.php

namespace TEST\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller

{
    public function indexAction($page)
    {
        // ...
        // Notre liste d'annonce en dur
        $listAdverts = array(

            array(
                'title'   => 'Recherche développpeur Symfony',
                'id'      => 1,
                'author'  => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date'    => new \Datetime()),

                array(
                    'title'   => 'Mission de webmaster',
                    'id'      => 2,
                    'author'  => 'Hugo',
                    'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                    'date'    => new \Datetime()),

                    array(
                        'title'   => 'Offre de stage webdesigner',
                        'id'      => 3,
                        'author'  => 'Mathieu',
                        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                        'date'    => new \Datetime())
                    );

                    // Et modifiez le 2nd argument pour injecter notre liste
                    return $this->render('TESTPlatformBundle:Advert:index.html.twig', array(
                        'listAdverts' => $listAdverts
                    ));
                }

                public function menuAction()
                {
                    // On fixe en dur une liste ici, bien entendu par la suite
                    // on la récupérera depuis la BDD !

                    $listAdverts = array(
                        array('id' => 2, 'title' => 'Recherche développeur Symfony'),
                        array('id' => 5, 'title' => 'Mission de webmaster'),
                        array('id' => 9, 'title' => 'Offre de stage webdesigner'),
                        array('id' => 19, 'title' => 'Offre de testeur')
                    );

                    return $this->render('TESTPlatformBundle:Advert:menu.html.twig', array(
                        // Tout l'intérêt est ici : le contrôleur passe
                        // les variables nécessaires au template !
                        'listAdverts' => $listAdverts
                    ));
                }


                public function viewAction($id)
                {
                    $advert = array(
                        'title'   => 'Recherche développpeur Symfony2',
                        'id'      => $id,
                        'author'  => 'Alexandre',
                        'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
                        'date'    => new \Datetime()
                    );

                    return $this->render('TESTPlatformBundle:Advert:view.html.twig', array(
                        'advert' => $advert
                    ));
                }



                public function addAction(Request $request)
                {
                    // On récupère le service

                    $antispam = $this->container->get('test_platform.antispam');

                    // Je pars du principe que $text contient le texte d'un message quelconque
                    $text = '...aaaaaadfdfdfsfdsfdsfdsfdsfdsfdsfdsfdsdsfdsfdsfaaaaaaa';


                    if ($antispam->isSpam($text)) {
                        throw new \Exception('Votre message a été détecté comme spam !');
                    }

                    // Ici le message n'est pas un spam
                    return $this->render('TESTPlatformBundle:Advert:add.html.twig',array(

                        'message'=>$text
                    )
                    );
                }



                public function deleteAction($id)
                {
                    // Ici, on récupérera l'annonce correspondant à $id
                    // Ici, on gérera la suppression de l'annonce en question
                    return $this->render('TESTPlatformBundle:Advert:delete.html.twig');
                }

                public function editAction($id, Request $request)

                {
                    $advert = array(
                        'title'   => 'Recherche développpeur Symfony',
                        'id'      => $id,
                        'author'  => 'Alexandre',
                        'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                        'date'    => new \Datetime()
                    );

                    return $this->render('TESTPlatformBundle:Advert:edit.html.twig', array(
                        'advert' => $advert

                    ));

                }




            }
