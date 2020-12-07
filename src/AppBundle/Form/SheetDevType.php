<?php

namespace AppBundle\Form;

use AppBundle\Entity\society;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Years;

class SheetDevType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('society', EntityType::class,[
                     'class' => society::class,

                     'query_builder' => function(EntityRepository $so){
                         return $so->createQueryBuilder('s')
                                   ->orderBy('s.societyName', 'ASC');
                     }
        ])
                ->add('years', EntityType::class, [
                    // looks for choices from this entity
                    'class' => Years::class,

                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                                  ->orderBy('a.years', 'ASC');
                    },

                    'label' => 'Année en cours'
                ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SheetDev'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_sheetdev';
    }


}
