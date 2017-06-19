<?php

namespace SMS\StudyPlanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use SMS\StudyPlanBundle\Entity\Exam;
use SMS\StudyPlanBundle\Entity\TypeExam;
use SMS\StudyPlanBundle\Entity\Session;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use API\Form\EventSubscriber\GradeSectionCourseFilterListener;

class ExamEditType extends AbstractType
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
            ->addEventSubscriber(new GradeSectionCourseFilterListener($this->em))
            ->add('examName' ,TextType::class , array(
                'label' => 'exam.field.examName')
            )
            ->add('dateExam', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'exam.field.dateExam' ,
                'attr' => [ 'data-uk-datepicker'=> "{format:'YYYY-MM-DD'}"],
            ))

            ->add('startTime', TimeType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'exam.field.startTime' ,
                'attr' => [ 'data-uk-timepicker'=> ""],
            ))
            ->add('endTime', TimeType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'exam.field.endTime' ,
                'attr' => [ 'data-uk-timepicker'=> ""],
            ))
            ->add('typeExam' , EntityType::class , array(
                'class' => TypeExam::class,
                'property' => 'typeExamName',
                'placeholder'=> 'exam.field.typeExam',
                'label' => 'exam.field.typeExam')
            )


            ->add('save', SubmitType::class);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Exam::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sms_studyplanbundle_exam';
    }


}
