<?php

namespace Styleflasher\EntityExportBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use Doctrine\ORM\Query;

class OverviewController extends Controller
{
    public function overviewAction()
    {
        $groups = $this->container->getParameter('styleflasher_entity_export.groups');
        $helper = $this->get('styleflasher_entity_export.helper');
        $result = $helper->enrichConfiguration($groups);

        return $this->render(
            'StyleflasherEntityExportBundle:Overview:index.html.twig',
            array(
                'groups' => $result,
            )
        );
    }

    public function getGroupsAction()
    {
        $helper = $this->get('styleflasher_entity_export.helper');
        return $helper->enrichConfiguration($this->container->getParameter('styleflasher_entity_export.groups'));
    }
}
