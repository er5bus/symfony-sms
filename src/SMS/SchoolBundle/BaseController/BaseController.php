<?php

namespace SMS\SchoolBundle\BaseController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Base controller of StudyPlanBundle
 * @author Rami Sfari <rami2sfari@gmail.com>
 * @copyright Copyright (c) 2017, SMS
 */

class BaseController extends Controller
{

	/**
     * Adds a flash success message to the current session.
     *
     * @param string $message The message
     */
    protected function flashSuccessMsg($message)
    {
        $this->addFlash($this->getParameter('flash_msg_success') , $this->get('translator')->trans($message));
    }

    /**
     * Adds a flash error message to the current session.
     *
     * @param string $message The message
     */
    protected function flashErrorMsg($message)
    {
        $this->addFlash($this->getParameter('flash_msg_error') , $this->get('translator')->trans($message));
    }

    /**
     * get Entity Manager Service.
     *
     * @return API\Services\EntityManager
     *
     * @throws \NotFoundException
     */
    protected function getEntityManager()
    {
        if (!$this->has('sms.school.entity_manager')){
           throw $this->createNotFoundException('Service Not Found');
        }
        return $this->get('sms.school.entity_manager');
    }

    /**
     * get datatable query Service.
     * @throws \NotFoundException
     */
    protected function getDataTableQuery()
    {
        if (!$this->has('sg_datatables.query')){
           throw $this->createNotFoundException('Service Not Found');
        }
        return $this->get('sg_datatables.query');
    }

    /**
     * get datatable query Service.
     * @throws \NotFoundException
     */
    protected function getSerializer()
    {
        if (!$this->has('serializer')){
           throw $this->createNotFoundException('Service Not Found');
        }
        return $this->get('serializer');
    }
}
