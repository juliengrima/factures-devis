<?php

namespace AppBundle\Form;

use AppBundle\Entity\SheetDev;
use AppBundle\Entity\Years;
use Doctrine\DBAL\Platforms\SQLServer2005Platform;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SheetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('provider')
                ->add('sheetdev', EntityType::class, [
                    // looks for choices from this entity
                    'class' => SheetDev::class,
                    'choice_label' => static function($sheetDev){
                        return $sheetDev->getSociety()->getSocietyName().'-'.$sheetDev->getYears().'D00'.$sheetDev->getId();
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
            'data_class' => 'AppBundle\Entity\Sheet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_sheet';
    }


}
