<?php

namespace GameOfLife\WorldReader;

use Exception;

class InvalidWorldConfiguration extends Exception
{

    public static function byNonExistingField(string $field): self
    {
        return new self(sprintf("Field '%s' doesn't exist", $field));
    }

    public static function byNonExistingAttribute(string $field, string $attribute): self
    {
        return new self(sprintf("Attribute '%s' doesn't exist for field '%s'", $attribute, $field));
    }

}
