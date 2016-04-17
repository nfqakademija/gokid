<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class OfferType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Būrelio pavadinimas',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Papildoma informacija',
            ])
            ->add('price', null, [
                'label' => 'Kaina',
            ])
            ->add('male', null, [
                'label' => 'Berniukams',
            ])
            ->add('female', null, [
                'label' => 'Mergaitėms',
            ])
            ->add('ageFrom', null, [
                'label' => false,
            ])
            ->add('ageTo', null, [
                'label' => false,
            ])
            ->add('address', null, [
                'label' => 'Adresas',
            ])
            ->add('images', FileType::class, [
                'label' => 'Nuotraukos',
                'multiple' => true,
            ])
            ->addModelTransformer(new ImageTransformer())
            ->add('activity', null, [
                'label' => 'Sporto šaka',
            ])
            ->add('latitude', null, [
                'label' => false,
            ])
            ->add('longitude', null, [
                'label' => false,
            ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Offer'
        ));
    }
}
