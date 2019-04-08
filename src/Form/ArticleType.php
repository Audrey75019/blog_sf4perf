<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label'=>'Titre de l\'article'])
            ->add('description', null, ['label'=>'Description de l\'article'])
            ->add('imageSrc', null, ['label'=>'Image de l\'article'])
            ->add('imageAlt', null, ['label'=>'Descrition de l\image SEO'])
            ->add('isPublished', null, ['label'=>"l'article doit être publié"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
