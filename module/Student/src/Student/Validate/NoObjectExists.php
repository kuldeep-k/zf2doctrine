<?php

namespace Student\Validate;

use DoctrineModule\Validator\NoObjectExists as DoctrineModuleNoObjectExists;

class NoObjectExists extends DoctrineModuleNoObjectExists
{
    protected $messageTemplates = array(
        self::ERROR_OBJECT_FOUND    => "An object matching combination of fields was found",
    );

    /**
     * {@inheritDoc}
     */
    public function isValid($value, $context = null)
    {
        foreach($this->fields as $name => $val)
        {
            $valueArray[] = $context[$val];
        }    
        $value = $this->cleanSearchValue($valueArray);
        
        $match = $this->objectRepository->findOneBy($value);
        
        if (is_object($match)) {
            $this->error(self::ERROR_OBJECT_FOUND, $value);

            return false;
        }

        return true;
    }
}
