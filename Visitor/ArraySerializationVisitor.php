<?php

namespace EPWT\ArrayJMSSerializerBundle\Visitor;

use JMS\Serializer\Context;
use JMS\Serializer\GenericSerializationVisitor;
use JMS\Serializer\Metadata\ClassMetadata;

/**
 * Class ArraySerializationVisitor
 * @package EPWT\ArrayJMSSerializerBundle\Visitor
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class ArraySerializationVisitor extends GenericSerializationVisitor
{
    /**
     * @return array
     */
    public function getResult()
    {
        return $this->getRoot();
    }

    /**
     * @param array $data
     * @param array $type
     * @param Context $context
     * @return array|\ArrayObject|mixed
     */
    public function visitArray($data, array $type, Context $context)
    {
        $result = parent::visitArray($data, $type, $context);
        if (null !== $this->getRoot() && isset($type['params'][1]) && 0 === count($result)) {
            // ArrayObject is specially treated by the json_encode function and
            // serialized to { } while a mere array would be serialized to [].
            return new \ArrayObject();
        }
        return $result;
    }

    /**
     * @param ClassMetadata $metadata
     * @param mixed $data
     * @param array $type
     * @param Context $context
     * @return \ArrayObject
     */
    public function endVisitingObject(ClassMetadata $metadata, $data, array $type, Context $context)
    {
        $rs = parent::endVisitingObject($metadata, $data, $type, $context);
        // Force JSON output to "{}" instead of "[]" if it contains either no properties or all properties are null.
        if (empty($rs)) {
            $rs = new \ArrayObject();
            if (array() === $this->getRoot()) {
                $this->setRoot(clone $rs);
            }
        }
        return $rs;
    }
}
