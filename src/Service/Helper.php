<?php
namespace Styleflasher\EntityExportBundle\Service;

use eZ\Publish\API\Repository\LocationService;

class Helper
{
    private $locationService;
    private $configResolver;
    private $config;
    private $storageDirs;

    public function __construct(LocationService $locationService, $configResolver, $config)
    {
        $this->configResolver = $configResolver;
        $this->config = $config;
        $this->locationService = $locationService;
    }

    public function enrichConfiguration($groups)
    {
        $result = [];
        foreach ($groups as $key => $group) {
            $entities = [];
            foreach ($group['entities'] as $entityKey => $entity) {
                $location = $this->locationService->loadLocation($entity['locationId']);
                $entity['location'] = $location;
                $entity['name'] = $location->getContentInfo()->name;
                $entities[$entityKey] = $entity;
            }
            $result[$key] = array('entities'=> $entities);
        }
        return $result;
    }

    public function convertEntitiesToString($entities)
    {
        $reflect = new \ReflectionClass($entities[0]);
        $alias = $reflect->getShortName();
        $this->findStorageDirs($alias);
        $result = [];
        foreach ($entities as $key => $val) {
            $item = [];
            $item['id'] = $val->getId();
            foreach ($val as $key => $attr) {
                if (isset($this->storageDirs[$key]) && $attr) {
                    $item[$key] = $this->generateLink(
                        $this->configResolver->getParameter('io.url_prefix').$this->storageDirs[$key]['dir'].$attr
                    );
                    continue;
                }
                if ($attr instanceof \DateTime) {
                    $item[$key] = $attr->format('Y-m-d H:i:s');
                    continue;
                }
                $item[$key] = $attr;
            }
            $result[]=$item;
        }
        return $result;
    }

    public function findStorageDirs($alias)
    {
        foreach ($this->config as $conf) {
            foreach ($conf as $entity) {
                foreach ($entity as $configDetail) {
                    if ($configDetail['entity'] === $alias) {
                        $this->storageDirs = $configDetail['storageDirs'];
                    }
                }
            }
        }
    }

    public function findLocationNameByEntityName($entityName)
    {
        foreach ($this->config as $conf) {
            foreach ($conf as $entity) {
                foreach ($entity as $configDetail) {
                    if ($configDetail['entity'] === $entityName) {
                        $location = $this->locationService->loadLocation($configDetail['locationId']);
                        return $location->getContentInfo()->name;
                    }
                }
            }
        }

    }

    public function generateLink($url)
    {
        return '<a href="/'.$url.'" _target="_blank">'.$url.'</a>';
    }
}
