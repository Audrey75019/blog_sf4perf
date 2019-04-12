<?php
namespace App\DataFixtures;
use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\ORM\Doctrine\Populator;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = Factory::create('fr_FR');
        $populator = new Populator($generator, $manager);
        $populator->addEntity(Article::class, 150, [
            'title' => function () use ($generator) {
                return $generator->text(64);
            }
        ]);
        $populator->addEntity(Comment::class, 500);
        $populator->execute();
    }
}
