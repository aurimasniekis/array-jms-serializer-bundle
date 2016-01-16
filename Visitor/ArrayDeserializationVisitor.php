<?php

namespace EPWT\ArrayJMSSerializerBundle\Visitor;

use JMS\Serializer\GenericDeserializationVisitor;

/**
 * Class ArrayDeserializationVisitor
 * @package EPWT\ArrayJMSSerializerBundle\Visitor
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class ArrayDeserializationVisitor extends GenericDeserializationVisitor
{
    protected function decode($str)
    {
        return $str;
    }
}
