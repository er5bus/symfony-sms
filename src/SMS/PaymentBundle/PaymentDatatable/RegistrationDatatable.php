<?php

namespace SMS\PaymentBundle\PaymentDatatable;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class RegistrationDatatable
 *
 * @package SMS\PaymentBundle\Datatables
 */
class RegistrationDatatable extends AbstractDatatableView
{
  /**
   * @var String Class Names
   */
  protected $paymentTypeClass;

  /**
   * Session class
   *
   * @param String Class Names
   */
  function setPaymentTypeClass( $paymentTypeClass)
  {
      $this->paymentTypeClass = $paymentTypeClass;
  }


    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
      $establishment = $this->securityToken->getToken()->getUser()->getEstablishment();
      $typePayments = $this->em->getRepository($this->paymentTypeClass)->findBy(array("establishment" => $establishment));


        $this->callbacks->set(array(
        'row_callback' => array(
            'template' => 'Pagination/row_callback.js.twig',
            )
        ));


        $this->options->set(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => "<'dt-uikit-header'<'uk-grid'<'uk-width-medium-2-3'l><'uk-width-medium-1-3'f>>><'uk-overflow-container'tr><'dt-uikit-footer'<'uk-grid'<'uk-width-medium-3-10'i><'uk-width-medium-7-10'p>>>",
            'length_menu' => array(10, 25, 50, 100),
            'order_classes' => true,
            'order' => array(array(1, 'asc')),
            'order_multi' => true,
            'page_length' => 10,
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
            'renderer' =>  'uikit',
            'scroll_collapse' => false,
            'search_delay' => 0,
            'state_duration' => 7200,
            'class' => "uk-table uk-table-striped",
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'use_integration_options' => true,
            'force_dom' => true,
        ));

        $this->ajax->set(array(
            'url' => $this->router->generate('registration_results', array("id" => $options['id'])),
            'type' => 'GET',
            'pipeline' => 0
        ));

        $this->columnBuilder
            ->add(null, 'multiselect', array(
                'actions' => array(
                    array(
                        'route' => 'registration_registred',
                        'icon' => '&#xE923;',
                        'label' => $this->translator->trans('action.registered'),
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('action.registered'),
                            'class' => 'md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'registration_not_registred',
                        'icon' => '&#xE923;',
                        'label' => $this->translator->trans('action.not_registered'),
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('action.not_registered'),
                            'class' => 'md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light',
                            'role' => 'button'
                        ),
                    ),
                )
            ))
            ->add('paymentType.TypePaymentName', 'column', array(
                'title' => $this->translator->trans('paymentType.field.TypePaymentName'),
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => $this->translator->trans('filter.field.all')) + $this->getCollectionAsOptionsArray($typePayments, 'TypePaymentName', 'TypePaymentName'),
                    'class' => "tablesorter-filter"
                ))
            ))
            ->add('paymentType.price', 'column', array(
                'title' => $this->translator->trans('paymenttype.field.price'),
                "render" => $this->translator->trans('payment.unit.price'),
                'filter' => array('text', array(
                    'class' => "md-input"
                )),
            ))
            ->add('paymentType.registrationFee', 'column', array(
                'title' => $this->translator->trans('paymenttype.field.registrationFee'),
                "render" => $this->translator->trans('payment.unit.price'),
                'filter' => array('text', array(
                    'class' => "md-input"
                )),
            ))
            ->add('registered', 'boolean', array(
                'title' => $this->translator->trans('registration.field.registered'),
                'true_label' => $this->translator->trans('registration.registered.true_label'),
                'false_label' => $this->translator->trans('registration.registered.false_label'),
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => $this->translator->trans('filter.field.all') , true => $this->translator->trans('registration.registered.true_label') , false => $this->translator->trans('registration.registered.false_label')) ,
                    'class' => "tablesorter-filter"
                )),
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'registration_pdf',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'icon' => '&#xE8AD;',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.pdf'),
                        ),
                    )
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'SMS\PaymentBundle\Entity\Registration';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'registration_datatable';
    }
}
