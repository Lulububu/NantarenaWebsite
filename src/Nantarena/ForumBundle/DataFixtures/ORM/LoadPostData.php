<?php

namespace Nantarena\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\ForumBundle\Entity\Post;

class LoadPostData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // forum Discussion Club

        $post = new Post();
        $post->setUser($this->getReference('user-1'));
        $post->setContent('Un petit topic de test écrit de main de maitre');
        $post->setThread($this->getReference('thread-1'));
        $manager->persist($post);

        // forum Nantarena FAQ

        $post = new Post();
        $post->setUser($this->getReference('user-2'));
        $post->setContent('Une question qui me champouine : Qui est Jaconil ?');
        $post->setThread($this->getReference('thread-2'));
        $manager->persist($post);

        $post = new Post();
        $post->setUser($this->getReference('user-1'));
        $post->setContent('Je ne sais pas');
        $post->setThread($this->getReference('thread-2'));
        $manager->persist($post);

        // create 30 additionnal posts
        for ($i = 0; $i < 30; $i++) {
            $post = new Post();
            $post->setUser($this->getReference('user-'.(($i % 2) + 1)));
            $post->setContent('Réponse '.$i);
            $post->setThread($this->getReference('thread-2'));
            $manager->persist($post);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return array(
            'Nantarena\ForumBundle\DataFixtures\ORM\LoadThreadData',
        );
    }
}