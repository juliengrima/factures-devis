<?php

namespace AppBundle\Form;

use AppBundle\Entity\Sheet;
use AppBundle\Entity\SheetDev;
use AppBundle\Entity\Years;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sheet', EntityType::class, [
                    // looks for choices from this entity
                    'class' => Sheet::class,
                    'choice_label' => static function($sheet){
                        return $sheet->getSheetdev()
                                     ->getSociety()
                                     ->getSocietyName().'-'.$sheet->getSheetdev()
                                                                   ->getYears().'D00'.$sheet->getSheetdev()
                                                                                            ->getId().' ----> '.$sheet->getYears().'/00'.$sheet->getId();
                    },
//                    'group_by' => static function($sheet){
//                        return rand(0, 1) == 1 ? $sheet->getSheetdev()
//                                                        ->getSociety()
//                                                        ->getSocietyName().'-'.$sheet->getSheetdev()
//                                                                                     ->getYears().'D00'.$sheet->getSheetdev()
//                                                                                                              ->getId() : '';
//                    }
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
            'data_class' => 'AppBundle\Entity\Delivery'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_delivery';
    }


}
