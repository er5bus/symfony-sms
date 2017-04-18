<?php

namespace SMS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use SMS\UserBundle\Entity\Student;
use SMS\UserBundle\Entity\StudentParent;
use SMS\EstablishmentBundle\Entity\Section;
use Vich\UploaderBundle\Form\Type\VichImageType;
use API\Form\Type\GenderType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use API\Form\EventSubscriber\AddUsernamePasswordFieldListener;
use API\Form\EventSubscriber\GradeSectionFilterListener;

class StudentType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManager $em
     */
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile',  VichImageType::class, array(
                    'allow_delete' => false, // not mandatory, default is true
                    'download_link' => false, // not mandatory, default is true
                    'label' => false ,
                    'attr' => [ 'form.grid'=> "none"])
                )
            ->add('firstName' ,TextType::class , array(
                'label' => 'student.field.firstName')
            )
            ->add('lastName' ,TextType::class , array(
                'label' => 'student.field.lastName')
            )
            ->add('gender' ,GenderType::class , array(
                'label' => 'user.field.gender')
            )
            ->add('birthday', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'student.field.birthday' ,
                'attr' => [ 'data-uk-datepicker'=> "{format:'YYYY-MM-DD'}"],
            ))
            ->add('email' ,TextType::class , array(
                'label' => 'user.field.email')
            )  
            ->add('studentParent' , EntityType::class , array(
                'class' => StudentParent::class,
                'property' => 'fatherName',
                'label' => 'student.field.studentParent',
                'placeholder' => 'student.field.studentParent')
            )
            ->add('show_username_password', CheckboxType::class, array(
                'label' => 'user.field.show_username_password',
                'mapped' => false
                )
            )
            ->addEventSubscriber(new GradeSectionFilterListener($this->em)) 
            ->addEventSubscriber(new AddUsernamePasswordFieldListener())  
            ->add('save', SubmitType::class ,array(
                'validation_groups' => "SimpleRegistration",
                'label' => 'md-fab'
            ));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Student::class,
            'allow_extra_fields' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sms_userbundle_student';
    }


}
