<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * Class IndexSearchOffer
 * @package AppBundle\Form
 */
class IndexSearchOffer extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address', TextType::class, [
            'label' => false,
        ])->add('age', IntegerType::class, [
            'label' => false,
        ])->add('male', CheckboxType::class, [
            'label' => false,
        ])->add('female', CheckboxType::class, [
            'label' => false,
        ])->add('latitude', TextType::class, [
            'label' => false,
        ])->add('longitude', TextType::class, [
            'label' => false,
        ])->add('distance', TextType::class, [
            'label' => false,
            'data' => '10',
        ])->add('priceFrom', TextType::class, [
            'label' => false,
            'data' => '1',
        ])->add('priceTo', TextType::class, [
            'label' => false,
            'data' => '50',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'data_class' => 'AppBundle\Entity\OfferSearch',
            'csrf_protection' => false,
        ]);
    }

    /**
     * @return null
     */
    public function getName()
    {
        return null;
    }
}
