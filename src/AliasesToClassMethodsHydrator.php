<?php

namespace Smtm\Zfx\Hydrator;

use Zend\Hydrator\ClassMethods;

class AliasesToClassMethodsHydrator extends ClassMethods
{
    protected $mapHydration;
    protected $mapExtraction;

    public function __construct($underscoreSeparatedKeys = true, array $mapExtraction = [], ?array $mapHydration = [])
    {
        parent::__construct($underscoreSeparatedKeys);

        $this->mapExtraction = ($mapExtraction === null) ? array_flip($mapHydration) : $mapExtraction;
        $this->mapHydration = ($mapHydration === null) ? array_flip($mapExtraction) : $mapHydration;
    }

    public function hydrate(array $data, $object)
    {
        $reindexedData = [];
        foreach ($data as $key => $datum) {
            if (isset($this->mapHydration[$key])) {
                $reindexedData[$this->mapHydration[$key]] = $datum;
            } else {
                $reindexedData[$key] = $datum;
            }
        }

        return parent::hydrate($reindexedData, $object);
    }

    public function extract($object)
    {
        $data = parent::extract($object);

        $reindexedData = [];
        foreach ($data as $key => $datum) {
            if (isset($this->mapExtraction[$key])) {
                $reindexedData[$this->mapExtraction[$key]] = $datum;
            } else {
                $reindexedData[$key] = $datum;
            }
        }

        return $reindexedData;
    }
}
