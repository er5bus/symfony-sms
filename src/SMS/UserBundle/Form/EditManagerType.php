<?php

namespace SMS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use SMS\UserBundle\Form\Type\RoleType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use SMS\UserBundle\Entity\Manager;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditManagerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('imageFile',  VichImageType::class, array(
                    'allow_delete' => false, // not mandatory, default is true
                    'download_link' => false, // not mandatory, default is true
                    'label' => false )
                )
                ->add('firstName' ,TextType::class , array(
                    'label' => 'student.field.firstName')
                )
                ->add('lastName' ,TextType::class , array(
                    'label' => 'student.field.lastName')
                )

                ->add('email' ,TextType::class , array(
                    'label' => 'user.field.email')
                )
                ->add('phone' ,TextType::class , array(
                    'label' => 'professor.field.phone')
                )
                ->add('address' ,TextType::class , array(
                    'label' => 'professor.field.address')
                )
                ->add('enabled' ,CheckboxType::class , array(
        					'label' => 'user.field.enabled'
        					)
        				)
                ->add('roles' , RoleType::class , array(
        					'label' => 'user.field.role',
                  'multiple' => true,
        					)
        				)
                ->add('save', SubmitType::class ,array(
                    'validation_groups' => "Edit",
                    'label' => 'md-fab'
                ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Manager::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sms_userbundle_manager';
    }


}
