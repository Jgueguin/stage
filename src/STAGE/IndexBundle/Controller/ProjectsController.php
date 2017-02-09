<?php

namespace STAGE\IndexBundle\Controller;


use STAGE\IndexBundle\STAGEIndexBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


// Accés à la base de données
use STAGE\IndexBundle\Entity\ProjectEntity;

// gestion formulaire
use STAGE\IndexBundle\Form\ProjectEntityType;

class ProjectsController extends Controller
{

	// Affichage de la page index : Vues Index qui contient vues search et Liste
	public function indexAction(request $request)
	{

		//$session <===> $_SESSION[]
		$session = $request->getSession();

		// on récupère en get la valeur page_limit qui vient de la vue "Liste"

		//$limit <==> $_GET["page_limit"]
		$limit = $request->query->get( 'page_limit' );



		// si la valeur n'existe pas, on recupère la valeur qui a été enregistrée le coup d'avant dans la variable Session
		if(!$limit){
			//$page <===> $_SESSION["page"]
			$limit = $session->get("page_limit");

			if ($limit != 0) { $limit=0;}
		}


		// au sinon, elle existe et on la rentre dans la variable Session
		$session->set("page_limit",$limit);


		//$page <==> $_GET["page"]
		$page = $request->query->get( "page" );
		if(!$page){
			//$page <===> $_SESSION["page"]
			$page = $session->get("page");
		}
		$session->set("page",$page);


		//$title <==> $_GET["title"]
		$title = $request->query->get( "title" );
		if(!$title)   {
			//$title <===> $_SESSION["title"]
			//$title = $session->get("title");
			$title='';
		}
		$session->set("title",$title);


		//$content <==> $_GET["content"]
		$content = $request->query->get( "content" );
		if(!$content){
			//$content <===> $_SESSION["content"]
			// $content = $session->get("content");

			$content='';
		}
		$session->set("content",$content);


		if( !$page) {
			$page = 1;
		}

		if($page <= 0){
			$page = 1;
		}

		// On appelle le repository dans lequel se trouve toutes les informations de notre DB

		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('STAGEIndexBundle:ProjectEntity')
		;
		// préparation requête
		$em   = $this->getDoctrine()->getManager();
		$qb   = $em->getRepository( 'STAGEIndexBundle:ProjectEntity' )->createQueryBuilder( 'm' );
		$qb2  = $em->getRepository( 'STAGEIndexBundle:ProjectEntity' )->findAll();
		$projects = $qb ->where( '1 = 1' )
		;



		// fichier contenant requête à la DB
		include ("requestDB.php" );


		$result = $projects->getQuery()->getResult();

		// ->>>>  Combien avons-nous d'élements qui répondent à notre recherche ?????
		$counter = count($result);


		// calcul de la dernière page
		$last = ($limit != 0) ? ceil($counter / $limit) : 1;


		$session->set("last",$last);



		if ($last==0 && $limit!=0) {
			$last=1;
		}


		// vérification en cas de changement d'élements par page et que l'on dépasse le nbre d"élément dans la DB
		// on revient sur la dernière page

		if (($page * $limit) > $counter) {
			$page = $last;
		}


		// Fonctionnalité Pagination
		// cas où $limit n'est ni nul ni égal à 0, on effectue le calcul


		if ($limit != NULL && $limit != 0) {
			$projects->setMaxResults($limit)->setFirstResult(($page - 1) * $limit);
		} else {
			$page = 1;
		}

		// on récupère les resultats du Query
		$Projects = $projects->getQuery()->getResult();


		//nbre de characteres provenant du champ de recherche
		$nbrchar=strlen($content);


		// Au sinon, on continue et on affiche la vue associée en faisant passer en paramètres les informations récupérées de la DB
		return $this->render('STAGEIndexBundle:Projects:index.html.twig',
			array( 'Projects' => $Projects,
			       'Page'    => $page,
			       'offset'  => $limit,
			       'count'   => $counter,
			       'last'    => $last,
			       'title'   => $title,
			       'content' => $content,

			)
		);
	}



	// Méthode qui sert pour calculer les requêtes et afficher que la liste des résultats
	public function listeAction(request $request)
	{
		//$session <===> $_SESSION[]
		$session = $request->getSession();

		// on récupère en get la valeur page_limit qui vient de la vue "Liste"

		//$limit <==> $_GET["page_limit"]
		$limit = $request->query->get( 'page_limit' );



		// si la valeur n'existe pas, on recupère la valeur qui a été enregistrée le coup d'avant dans la variable Session
		if(!$limit){
			//$page <===> $_SESSION["page"]
			$limit = $session->get("page_limit");

			if ($limit != 0) { $limit=0;}
		}


		// au sinon, elle existe et on la rentre dans la variable Session
		$session->set("page_limit",$limit);


		//$page <==> $_GET["page"]
		$page = $request->query->get( "page" );
		if(!$page){
			//$page <===> $_SESSION["page"]
			$page = $session->get("page");
		}
		$session->set("page",$page);


		//$title <==> $_GET["title"]
		$title = $request->query->get( "title" );
		if(!$title)   {
			//$title <===> $_SESSION["title"]
			//$title = $session->get("title");
			$title='';
		}
		$session->set("title",$title);


		//$content <==> $_GET["content"]
		$content = $request->query->get( "content" );
		if(!$content){
			//$content <===> $_SESSION["content"]
			// $content = $session->get("content");

			$content='';
		}
		$session->set("content",$content);


		if( !$page) {
			$page = 1;
		}

		if($page <= 0){
			$page = 1;
		}

		// On appelle le repository dans lequel se trouve toutes les informations de notre DB

		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('STAGEIndexBundle:ProjectEntity')
		;
		// préparation acces à la DB
		$em   = $this->getDoctrine()->getManager();
		$qb   = $em->getRepository( 'STAGEIndexBundle:ProjectEntity' )->createQueryBuilder( 'm' );
		$qb2  = $em->getRepository( 'STAGEIndexBundle:ProjectEntity' )->findAll();
		$projects = $qb ->where( '1 = 1' )
		;


		// fichier contenant requête à la DB
		include ("requestDB.php" );



		$result = $projects->getQuery()->getResult();


		// ->>>>  Combien avons-nous d'élements qui répondent à notre recherche ?????
		$counter = count($result);


		// calcul de la dernière page
		$last = ($limit != 0) ? ceil($counter / $limit) : 1;

		if ($last==0 && $limit!=0) {
			$last=1;
		}


		// vérification en cas de changement d'élements par page et que l'on dépasse le nbre d"élément dans la DB
		// on revient sur la dernière page

		if (($page * $limit) > $counter) {
			$page = $last;
		}


		// Fonctionnalité Pagination
		// cas où $limit n'est ni nul ni égal à 0, on effectue le calcul


		if ($limit != NULL && $limit != 0) {
			$projects->setMaxResults($limit)->setFirstResult(($page - 1) * $limit);
		} else {
			$page = 1;
		}

		// on récupère les resultats du Query
		$Projects = $projects->getQuery()->getResult();


		//nbre de characteres provenant du champ de recherche
		$nbrchar=strlen($content);


		// Au sinon, on continue et on affiche la vue associée en faisant passer en paramètres les informations récupérées de la DB
		return $this->render('STAGEIndexBundle:Projects:liste.html.twig',
			array( 'Projects' => $Projects,
			       'Page' => $page,
			       'offset'=> $limit,
			       'count' => $counter,
			       'last' => $last,
			       'title' => $title,
			       'content' => $content,
			       'nbrchars' =>$nbrchar,

			)
		);
	}




	// Méthode qui sert pour la partie "Moteur de Recherche"
	public function searchAction(request $request)
	{
		//$session <===> $_SESSION[]
		$session = $request->getSession();

		// on récupère en get la valeur page_limit qui vient de la vue "Liste"

		//$limit <==> $_GET["page_limit"]
		$limit = $request->query->get( 'page_limit' );


		// si la valeur n'existe pas, on recupère la valeur qui a été enregistrée le coup d'avant dans la variable Session
		if(!$limit){
			//$page <===> $_SESSION["page"]
			$limit = $session->get("page_limit");

			if ($limit != 0) { $limit=0;}
		}


		// au sinon, elle existe et on la rentre dans la variable Session
		$session->set("page_limit",$limit);


		//$page <==> $_GET["page"]
		$page = $request->query->get( "page" );
		if(!$page){
			//$page <===> $_SESSION["page"]
			$page = $session->get("page");
		}
		$session->set("page",$page);


		//$title <==> $_GET["title"]
		$title = $request->query->get( "title" );
		if(!$title)   {
			//$title <===> $_SESSION["title"]
			//$title = $session->get("title");
			$title='';
		}
		$session->set("title",$title);


		//$content <==> $_GET["content"]
		$content = $request->query->get( "content" );
		if(!$content){
			//$content <===> $_SESSION["content"]
			// $content = $session->get("content");

			$content='';
		}
		$session->set("content",$content);


		if( !$page) {
			$page = 1;
		}

		if($page <= 0){
			$page = 1;
		}

		// On appelle le repository dans lequel se trouve toutes les informations de notre DB

		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('STAGEIndexBundle:ProjectEntity')
		;
		// préparation acces DB
		$em   = $this->getDoctrine()->getManager();
		$qb   = $em->getRepository( 'STAGEIndexBundle:ProjectEntity' )->createQueryBuilder( 'm' );
		$qb2  = $em->getRepository( 'STAGEIndexBundle:ProjectEntity' )->findAll();
		$projects = $qb ->where( '1 = 1' )
		;

		// fichier contenant requête à la DB
		include ("requestDB.php" );


		$result = $projects->getQuery()->getResult();

		// ->>>>  Combien avons-nous d'élements qui répondent à notre recherche ?????
		$counter = count($result);


		// calcul de la dernière page
		$last = ($limit != 0) ? ceil($counter / $limit) : 1;

		if ($last==0 && $limit!=0) {
			$last=1;
		}

		// vérification en cas de changement d'élements par page et que l'on dépasse le nbre d"élément dans la DB
		// on revient sur la dernière page

		if (($page * $limit) > $counter) {
			$page = $last;
		}

		// Fonctionnalité Pagination
		// cas où $limit n'est ni nul ni égal à 0, on effectue le calcul


		if ($limit != NULL && $limit != 0) {
			$projects->setMaxResults($limit)->setFirstResult(($page - 1) * $limit);
		} else {
			$page = 1;
		}

		// on récupère les resultats du Query
		$Projects = $projects->getQuery()->getResult();

		//nbre de characteres provenant du champ de recherche
		$nbrchar=strlen($content);


		// Au sinon, on continue et on affiche la vue associée en faisant passer en paramètres les informations récupérées de la DB
		return $this->render('STAGEIndexBundle:Projects:search.html.twig',
			array( 'Projects' => $Projects,
			       'Page' => $page,
			       'offset'=> $limit,
			       'count' => $counter,
			       'last' => $last,
			       'title' => $title,
			       'content' => $content,
			       'nbrchars' =>$nbrchar,

			)
		);
	}


	// Appel d'un formulaire et insertion en base de données
	public function newAction(Request $request)
	{
		//$session <===> $_SESSION[]
		$session = $request->getSession();

		// on récupère en get la valeur page_limit qui vient de la vue "Liste"

		//$limit <==> $_GET["page_limit"]

		$limit = $session->get("page_limit");
		$last = $session->get("last");






		// On crée un objet vide Project Entity (sans titre, sans date, sans content)
		$project = new ProjectEntity();

		// On rempli le formulaire ProjectEntityType avec les valeurs $project (projTitle = $project->getTitle() ...)
		$form= $this->get('form.factory')->create(new ProjectEntityType,$project);

		if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($project);
			$em->flush();

			$request->getSession()->getFlashBag()->add('project', 'project saved.');

			return $this->redirect($this->generateUrl('index_index_homepage',
				array(
					'page_limit'=>$limit,

					// une fois que l'on a rentré les infos, on va sur la dernière page
					'page'=> $last,
				))

			);

		}

		return $this->render('STAGEIndexBundle:Projects:new.html.twig', array(
			'form' => $form->createView(),
		));
	}


	// Entrée forcée d'informations dans la DB
	public function new2Action(Request $request)
	{


		//$session <===> $_SESSION[]
		$session = $request->getSession();

		// on récupère en get la valeur page_limit qui vient de la vue "Liste"

		//$limit <==> $_GET["page_limit"]

		$limit = $session->get("page_limit");
		$last  = $session->get("last");



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
		return $this->redirect($this->generateUrl('index_index_homepage',
			array(
				'page_limit'=>$limit,

				// une fois que l'on a rentré les infos, on va sur la dernière page
				'page'=> $last,
			))

		);






	}


	public function modifyAction(Request $request,$id)
	{
		//$session <===> $_SESSION[]
		$session = $request->getSession();

		// on récupère en get la valeur page_limit qui vient de la vue "Liste"

		//$limit <==> $_GET["page_limit"]

		$limit = $session->get("page_limit");
		$page  = $session->get("page");



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

			return $this->redirect($this->generateUrl('index_index_homepage',
				array(
						'page'   => $page,
						'offset' => $limit,

				)

			));

		}

		return $this->render('STAGEIndexBundle:Projects:modify.html.twig', array(
			'form' => $form->createView(),
		));
	}




	// Effacement d'une ligne dans la DB
	public function deleteAction($id)
	{
		//$session <===> $_SESSION[]
		$session = $request->getSession();

		// on récupère en get la valeur page_limit qui vient de la vue "Liste"

		//$limit <==> $_GET["page_limit"]

		$limit = $session->get("page_limit");
		$page  = $session->get("page");



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

		// on se redirige vers la index des projets
		return $this->redirect($this->generateUrl('index_index_homepage',
			array(
				'page'   => $page,
				'offset' => $limit,

			)
		));
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
