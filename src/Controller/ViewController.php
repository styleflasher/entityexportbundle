<?php

namespace Styleflasher\EntityExportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query;

class ViewController extends Controller
{
    private $entities;

    public function viewAction($entityName)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entities = $this->getDoctrine()
            ->getRepository('StyleflasherTirolerITBundle:'.$entityName)
            //->findAll(Query::HYDRATE_ARRAY);
            ->findAll();

        $helper = $this->get('styleflasher_entity_export.helper');
        $result = $helper->convertEntitiesToString($entities);
        return $this->render(
            'StyleflasherEntityExportBundle:View:index.html.twig',
            array(
                'name' => $entityName,
                'locationName' => $helper->findLocationNameByEntityName($entityName),
                'entities' => $result,
                'columns' => $this->getEntityColumnValues($entities[0], $entityManager)
            )
        );
    }

    public function getEntityColumnValues($entity, $entityManager)
    {
        $cols = $entityManager->getClassMetadata(get_class($entity))->getColumnNames();
        return $cols;
    }

    public function getGroupsAction()
    {
        $helper = $this->get('styleflasher_entity_export.helper');
        return $helper->enrichConfiguration($this->container->getParameter('styleflasher_entity_export.groups'));
    }

    /**
     * Get entities.
     *
     * @return entities.
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * Set entities.
     *
     * @param entities the value to set.
     */
    public function setEntities($entities)
    {
        $this->entities = $entities;
    }
}
