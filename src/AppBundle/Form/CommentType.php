<?php
/**
 * Created by PhpStorm.
 * User: rimas
 * Date: 4/13/16
 * Time: 1:45 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 * Class CommentType
 * @package AppBundle\Form
 */
class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('body', TextareaType::class, [
            'label' => 'Atsiliepimas',
        ])->add('rate', ChoiceType::class, [
                'label' => false,
                'choice_label' => false,
                'choices'  => [
                    '1.0' => 1,
                    '2.0' => 2,
                    '3.0' => 3,
                    '4.0' => 4,
                    '5.0' => 5,
                ],
                'expanded' => true,
                'multiple' => false,
        ])->add('title', TextType::class, [
                'label' => 'Atsiliepimo pavadinimas',
        ])->add('name', TextType::class, [
                'label' => 'Jūsų vardas',
        ])->add('email', EmailType::class, [
                'label' => 'El. pašto adresas',
        ])->add('submit', 'submit', [
                'label' => 'Įvertinti',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Comment',
        ]);
    }
}
