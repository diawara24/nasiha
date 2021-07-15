<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Video;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\VideoRepository;
use Gedmo\Mapping\Annotation\Slug;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class NasihaController extends AbstractController
{
    /**
     * @Route("/nasiha", name="nasiha")
     */
    public function index(): Response
    {
        return $this->render('nasiha/index.html.twig', [
            'controller_name' => 'NasihaController'
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(ArticleRepository $repo, VideoRepository $repo1): Response
    {
        $articleRecents = $repo->getArticleRecent();
        $videoRecents = $repo1->getVideoRecent();
        return $this->render('nasiha/home.html.twig', [
            'controller_name' => 'NasihaController',
            'articleRecents' => $articleRecents,
            'videoRecents' => $videoRecents
        ]);
    }

    /**
     * @Route("/videos", name="videos")
     */
    public function videos(CategoryRepository $repo): Response
    {
        $categories = $repo->findAll();
        
        return $this->render('nasiha/videos/video.html.twig', [
            'controller_name' => 'NasihaController',
            'categories' => $categories

        ]);
    }

    /**
     * @Route("/toutes-videos", name="toutes_videos")
     */
    public function toutesVideo(VideoRepository $repo, Request $request): Response
    {
        // definir le nobre de d'element par page
        $limit = 12;
        // On recupere le numero de page
        $page = $request->query->get('page', 1);
        //On recupere les annonce par page
        $videos = $repo->getPaginatedVideos($page, $limit);
        //On recupere le nombre total de video
        $total = $repo->getTotalVideos();


        
        return $this->render('nasiha/videos/toutesVideos.html.twig', compact('videos', 'page', 'limit', 'total'));
    }


    /**
     * @Route("/videos-categorie/{slug}", name="videos_categorie")
     */
    public function videosByCategorie(string $slug, CategoryRepository $repo): Response
    {
        $categories = $repo->getVideosByCategorie($slug);

        return $this->render('nasiha/videos/videosCategorie.html.twig', compact('categories'));
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function articles(ArticleRepository $repo, Request $request): Response
    {
        $articles = $repo->findAll();

        // definir le nobre de d'element par page
        $limit = 8;

        // On recupere le numero de page
        $page = $request->query->get('page', 1);

        //On recupere les annonce par page
        $videos = $repo->getPaginatedArticles($page, $limit);

        //On recupere le nombre total de video
        $total = $repo->getTotalArticles();

        return $this->render('nasiha/articles/article.html.twig', compact('articles', 'page', 'limit', 'total'));
    }

    /**
     * @Route("/article/{slug}", name="show_articles")
     */
    public function showArticles(Article $article, ArticleRepository $repo, VideoRepository $repo1): Response
    {
        $articleRecent = new Article();
        $articleRecent = $repo->getArticleRecent();
        $videoRecent = $repo1->getVideoRecent();
    
        return $this->render('nasiha/articles/showArticles.html.twig',[
            'article'=> $article,
            'articleRecents'=> $articleRecent,
            'videoRecents' => $videoRecent
        ]);
    }

     /**
     * @Route("/contacts", name="contacts")
     */
    public function contacts(Request $request, MailerInterface $mailler): Response
    {
        $form = $this->createForm(ContactType::class);
        $contact= $form->handleRequest($request);
        // Creation du email
       if ($form->isSubmitted() && $form->isValid()) {
           $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('adinounasiha28@gmail.com ')
                ->subject($contact->get('sujet')->getData())
                ->htmlTemplate('nasiha/contact/message.html.twig')
                ->context([
                    'nom'   => $contact->get('nom')->getData(),
                    'mail' => $contact->get('email')->getData(),
                    'sujet' => $contact->get('sujet')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            // envoie du email
            $mailler->send($email);
            
            // confirmation du email
            $this->addFlash('message','Votre email a bien été envoyé');
            
            // Redirection
            return $this->redirectToRoute('contacts');
       } 
        
        return $this->render('nasiha/contact/contact.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
