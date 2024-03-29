<?php

namespace API\Form\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use API\Form\Type\RoleType;
use SMS\UserBundle\Entity\Manager;
use SMS\EstablishmentBundle\Entity\Establishment;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class UsersListener
 *
 * @author Rami Sfari <rami2sfari@gmail.com>
 * @copyright Copyright (c) 2017, SMS
 * @package API\Form\EventSubscriber
 */
class UsersListener implements EventSubscriberInterface
{

    /**
     * @var String
     */
    private $_action ;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

        /**
     * Constructor
     *
     * @param EntityManager $em
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
            FormEvents::PRE_SET_DATA => 'preSetData'
            );
    }

    public function preSetData(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();

        if ($this->tokenStorage->getToken()->getUser() instanceof Manager) {
            // Remove the submit button, we will place this at the end of the form later
                        $submit = $form->get('save');
            $form->remove('save');

            $form->add('establishment', EntityType::class, array(
                'class' => Establishment::class,
                'label' => 'user.field.establishment',
                      'placeholder'   => 'user.field.establishment',
                )
            );
                        // Add submit button again, this time, it's back at the end of the form
                $form->add($submit);
        }
        if (!$user || null === $user->getId()) {
            $this->_action = 'ADD';
        } elseif ($this->tokenStorage->getToken()->getUser()->getId() === $user->getId()) {
            $form->remove('show_username_password')
                  ->add('enabled', CheckboxType::class, array(
                      'label' => 'user.field.enabled')
                    );
        } else {
            $this->_action = 'EDIT';
            $form->remove('show_username_password')
                        ->add('enabled', CheckboxType::class, array(
                            'label' => 'user.field.enabled'
                            )
                        )->add('roles', RoleType::class, array(
                            'label' => 'user.field.role',
                            'empty_data'    => false,
                            'multiple'      => true)
                            )->add('save', SubmitType::class, array(
                    'validation_groups' => "Edit",
                    'label' => 'md-fab'
                ));
        }
    }

    public function onPreSubmit(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();
        if (!$user||!array_key_exists('show_username_password', $user) || $this->_action == 'EDIT') {
            return;
        }
        if (array_key_exists('show_username_password', $user)) {
            unset($user['save']);

            $form->add('username', TextType::class, array(
                'label' => 'user.field.username'
                    )
                )
                ->add('plainPassword', PasswordType::class, array(
                'label' => 'user.field.password'
                    )
                )->add('save', SubmitType::class, array(
                'validation_groups' => "Registration",
                'label' => 'md-fab'
            ));
        } else {
            unset($user['save']);
            $form->add('save', SubmitType::class, array(
                'validation_groups' => "SimpleRegistration",
                'label' => 'md-fab'
            ));

            unset($user['username']);
            unset($user['plainPassword']);
            $event->setData($user);
        }
    }
}
