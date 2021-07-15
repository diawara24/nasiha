<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Video;
use App\Form\CategoriesType;
use App\Form\ConnexionType;
use App\Form\InscriptionType;
use App\Form\VideosType;
use App\Repository\CategoryRepository;
use App\Repository\VideoRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
     /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ConnexionType::class);
        $form->handleRequest($request);
        return $this->render('admin/user/profil.html.twig', [
            'controller_name' => 'AdminController',
            'connexionForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/user/ajout", name="ajout_admin")
     */
    public function ajouteAdmin(Request $request, ObjectManager $manager): Response
    {
        $user = new User();
        
        $form = $this->createForm(InscriptionType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);

            $manager->flush();
             
            return $this->redirectToRoute("admin");
        }

        return $this->render('admin/user/inscription.html.twig', [
            'inscriptionForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(Request $request): Response
    {
        $form = $this->createForm(ConnexionType::class);
        $form->handleRequest($request);
        return $this->render('admin/user/connexion.html.twig', [
            'controller_name' => 'AdminController',
            'connexionForm' => $form->createView()
        ]);
    }

    // -------------------------- gestion des categorie de video -------------------------- 
    
    /**
     * @Route("/admin/categories", name="admin_categorie")
     */
    public function categorire(CategoryRepository $repo): Response
    {
        $categoties = new Category(); 
        $categoties = $repo->findAll();
        return $this->render('admin/categories/index.html.twig', [
            'controller_name' => 'AdminController',
            'categoties' => $categoties
        ]);
    }

    /**
     * @Route("/admin/categorie/ajout", name="ajout_categorie")
     */
    public function ajoutCategorie(Request $request, ObjectManager $manager): Response
    {
        $categorie = new Category(); 
        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);

            $manager->flush();

            return $this->redirectToRoute('admin_categorie');
        }
        return $this->render('admin/categories/ajout.html.twig', [
            'form_cat'=> $form->createView()
            
        ]);
    }
    /**
     * @Route("/admin/categorie/modifier/{id}", name="modifier_categirie")
     */
    public function modifierCategorie(Category $categorie,Request $request, ObjectManager $manager): Response
    {
        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);

            $manager->flush();

            return $this->redirectToRoute('admin_categorie');
        }
        return $this->render('admin/categories/ajout.html.twig', [
            'form_cat'=> $form->createView()
            
        ]);
    }

    // -------------------------- gestion des videos -------------------------- 
    /**
     * @Route("/admin/videos", name="admin_videos")
     */
    public function ajouterVideo(VideoRepository $repo): Response
    {
        $videos = new video();
        $videos = $repo->findAll();
        
        return $this->render('admin/videos/index.html.twig', [
            'videos'=> $videos
            
        ]);
    }

    /**
     * @Route("/admin/video/ajout", name="ajout_video")
     */
    public function ajoutVideo(Request $request, ObjectManager $manager): Response
    {
        $video = new Video(); 
        $form = $this->createForm(VideosType::class, $video);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($video);

            
            $manager->flush();

            return $this->redirectToRoute('admin_videos');
        }
        return $this->render('admin/videos/ajout.html.twig', [
            'form_video'=> $form->createView()
            
        ]);
    }
    /**
     * @Route("/admin/video/modifier/{id}", name="modifier_video")
     */
    public function modifierVideo(Video $video,Request $request, ObjectManager $manager): Response
    {
        $form = $this->createForm(VideosType::class, $video);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($video);

            $manager->flush();

            return $this->redirectToRoute('admin_videos');
        }
        return $this->render('admin/videos/ajout.html.twig', [
            'form_video'=> $form->createView()
            
        ]);
    }

     /**
     * @Route("/admin/video/supprimer/{id}", name="supprimer_video")
     */
    public function supprimerVideo(Video $video, ObjectManager $manager): Response
    {
        $manager->remove($video);
        $manager->flush();

        $this->addFlash('message', 'Video supprimé qvec succès');

        return $this->redirectToRoute('admin_videos');
    }

}
