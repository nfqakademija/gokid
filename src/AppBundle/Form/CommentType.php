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
            'label' => false,
            'attr' => array('class' => 'tinymce'),
        ])->add('rate', ChoiceType::class, [
                'label' => false,
                'choice_label' => false,
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'expanded' => true,
                'multiple' => false,
        ])->add('title', TextType::class, [
                'label' => false,
        ])->add('name', TextType::class, [
                'label' => false,
        ])->add('email', EmailType::class, [
                'label' => false,
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
