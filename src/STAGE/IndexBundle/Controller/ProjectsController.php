<?php

namespace STAGE\IndexBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//gestion sessions
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

// Accés à la base de données
use STAGE\IndexBundle\Entity\ProjectEntity;

// gestion formulaire
use STAGE\IndexBundle\Form\ProjectEntityType;

class ProjectsController extends Controller
{

    // Affichage du contenu de la DB
    public function listeAction(request $request)
    {
        $session = new Session(new MockFileSessionStorage());
        //$session -> start();



        // on récupère les élements de la pagination (page et elments par page)
        $page             = $request->query->get( "page" );
        $limit            = $request->query->get( "page_limit" );
        // On vérifie ici si on a reçu des paramètres de la fonction "Search"
        $title        = $request->query->get( "title" );
        $content      = $request->query->get( "content" );

        if( !$page) {
            $page = 1;
        }

        if($page <= 0){
            $page = 1;
        }

        if( !$title ) {
            $title   = '';
            $content = '';
        }

        // On appelle le repository dans lequel se trouve toutes les informations de notre DB
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('STAGEIndexBundle:ProjectEntity')
        ;
        // préparation requête
        $em   = $this->getDoctrine()->getManager();
        $qb   = $em->getRepository( "STAGEIndexBundle:ProjectEntity" )->createQueryBuilder( "m" );
        $qb2  = $em->getRepository( "STAGEIndexBundle:ProjectEntity" )->findAll();
        $projects = $qb ->where( "1 = 1" )
        ;


        // comptage du nombre d'éléments totaux dans la base
        $counter = count($qb2);


        // Vérification que l'on a au moins un élément en base pour éviter des affichages d'erreurs
        if ($counter>0) {

            // on transmet les paramètres de recherche pour trier les infos dans la DB
            $projects = $projects->andWhere
            ( " m.projDescr LIKE :param1 AND m.projTitle LIKE :param2" )
            ->setParameters(
                array(
                    "param1"=>"%" . $content . "%",
                    "param2"=>"%" . $title . "%"
                ));

                // ->>>>  Combien avons-nous d'élements qui répondent à la recherche ?????

                // calcul de la dernière page
                $last = ($limit != 0)?ceil($counter/$limit):1;
                echo "last page: ".$last;
                echo "<br>";
                echo "counter: ".$counter;
                echo "<br>";
                echo "limite: ".$limit;
                echo "<br>";
                echo "page actuelle: ".$page;
                echo "<br>";
                echo "title: ".$title;

                // vérification en cas de changement d'élements par page et que l'on dépasse le nbre d"élément dans la DB
                // on revient sur la dernière page

                if ( ($page * $limit) > $counter ) {
                    $page = $last;
                }

                // Fonctionnalité Pagination
                // cas où $limit n'est ni nul ni égal à 0, on effectue le calcul

                // il faut aussi vérifier si on a un element en base

                if ($limit != NULL && $limit != 0) {
                    $projects->setMaxResults( $limit )->setFirstResult( ( $page - 1 ) * $limit );
                } else {
                    $page=1;
                }

            }
            // on récupère les resultats du Query
            $Projects = $projects->getQuery()->getResult();






            // si il n'ya aucun resultat du query :
            if (!$Projects) {
                return $this->render('STAGEIndexBundle:Projects:delete.html.twig',
                array(  'info'=> "No data into DB",
                'titre' => "Projects List",
            ));
        }


        // récuperation des parametres dans l'url
        $param=$_SERVER['QUERY_STRING'];

        $session->getFlashBag()->add('param', $param);

        foreach ($session->getFlashBag()->get('param', array()) as $message) {
            echo '<div class="flash-notice"> List: '.$message.'</div>';}


            // Au sinon, on continue et on affiche la vue associée en faisant passer en paramètres les informations récupérées de la DB
            return $this->render('STAGEIndexBundle:Projects:liste.html.twig',
            array( 'Projects' => $Projects,
            'Page' => $page,
            'offset'=> $limit,
            'count' => $counter,
            'last' => $last,
            'title' => $title,
            'content' => $content,

        )
    );
}




// Appel d'un formulaire et insertion en base de données
public function newAction(Request $request)
{
    // On crée un objet vide Project Entity (sans titre, sans date, sans content)
    $project = new ProjectEntity();

    // On rempli le formulaire ProjectEntityType avec les valeurs $project (projTitle = $project->getTitle() ...)
    $form= $this->get('form.factory')->create(new ProjectEntityType,$project);

    if ($form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        $request->getSession()->getFlashBag()->add('project', 'project saved.');

        // return $this->redirect($this->generateUrl('view_index_homepage', array('id' => $project->getId())));
        return $this->redirect($this->generateUrl('liste_index_homepage'));

    }

    return $this->render('STAGEIndexBundle:Projects:new.html.twig', array(
        'form' => $form->createView(),
    ));
}


// Entrée forcée d'informations dans la DB
public function new2Action(Request $request)
{
    // Création de l'entité
    $project = new ProjectEntity();

    $project -> setProjDate(new \Datetime());
    $project -> setProjTitle('Project Template Name');
    $project -> setProjDescr('Project Template Content');

    // On récupère l'EntityManager
    $doctrine= $this-> getDoctrine();
    $em = $doctrine -> getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($project);

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    $em->flush();

    // on se redirige vers la liste des projets
    return $this->redirect($this->generateUrl('liste_index_homepage'));
}


public function modifyAction(Request $request,$id)
{

    //récupération des paramétres dans l'url

    // $session = new Session(new MockFileSessionStorage());
    $session = new Session();

    foreach ($session->getFlashBag()->get('param', array()) as $message) {
        echo '<div class="flash-notice"> modify: '.$message.'</div>';}


        $em = $this->getDoctrine()->getManager();

        // On recupère un objet remplis Project Entity (abec titre, avec date, avec content)
        $project = $em-> getRepository('STAGEIndexBundle:ProjectEntity')->find($id);

        // On rempli le formulaire ProjectEntityType avec les valeurs $project (projTitle = $project->getTitle() ...)
        $form= $this->get('form.factory')->create(new ProjectEntityType,$project);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            $request->getSession()->getFlashBag()->add('project', 'project modified.');

            return $this->redirect($this->generateUrl('liste_index_homepage'));

            //return $this->render('STAGEIndexBundle:Projects:liste.html.twig',

            //array('par' => $_SESSION['param']  ));

        }

        return $this->render('STAGEIndexBundle:Projects:modify.html.twig', array(
            'form' => $form->createView(),
        ));
    }




    // Effacement d'une ligne dans la DB
    public function deleteAction($id)
    {
        //récupération de l'entityManager
        $em = $this->container->get('doctrine')->getEntityManager();

        // on récupére l'id qui nous interresse
        $project = $em->find('STAGEIndexBundle:ProjectEntity', $id);

        // si le projet demandé n'existe pas
        if (!$project)
        {
            return $this->render('STAGEIndexBundle:Projects:delete.html.twig',
            array( 'info'=> "doesn't exist", ));
        }

        // au sinon, il existe et on le supprime
        $em->remove($project);

        // on valide
        $em->flush();

        // on se redirige vers la liste des projets
        return $this->redirect($this->generateUrl('liste_index_homepage'));
    }


    public function viewAction($id)
    {
        $doctrine= $this->getDoctrine();
        $em = $doctrine -> getManager();

        // On récupère l'id entré avec la méthode find() dans le repository lié à notre Entité
        $project2 = $em->getRepository('STAGEIndexBundle:ProjectEntity')->find($id);

        return $this->render('STAGEIndexBundle:Projects:view.html.twig',
        array(
            'project' => $project2,

        )


    );
}

}
