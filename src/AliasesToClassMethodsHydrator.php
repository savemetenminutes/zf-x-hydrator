<?php

namespace Smtm\Zfx\Hydrator;

use Zend\Hydrator\ClassMethods;

class AliasesToClassMethodsHydrator extends ClassMethods
{
    protected $aliases;

    public function __construct($underscoreSeparatedKeys = true, array $aliases = [])
    {
        $this->aliases = $aliases;
        parent::__construct($underscoreSeparatedKeys);
    }

    public function hydrate(array $data, $object)
    {
        $reindexedData = [];
        foreach ($data as $key => $datum) {
            if (isset($this->aliases[$key])) {
                $reindexedData[$this->aliases[$key]] = $datum;
            } else {
                $reindexedData[$key] = $datum;
            }
        }

        return parent::hydrate($reindexedData, $object);
    }
}
