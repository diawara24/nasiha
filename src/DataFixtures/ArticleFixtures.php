<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       
        // utisation de faker pour generer de fausse donnees
            $faker = Faker\Factory::create();
            for ($j=1; $j < mt_rand(4, 8); $j++) { 
                $article = new Article();
                $content = '<p>'.join($faker->paragraphs(5),'</p><p>').'</p>';
                $article->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setImage("/img/mqdefault.jpg")
                        ->setCreatedAt($faker->dateTimeBetween('-8 months'));

                // preparer les donnees pour etre inserer dans la base de donnes
                $manager->persist($article);
                $manager->flush();
            }
    }
}
