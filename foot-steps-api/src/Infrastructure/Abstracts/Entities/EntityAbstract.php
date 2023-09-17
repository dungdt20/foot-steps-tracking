<?php

declare(strict_types=1);

namespace Infrastructure\Abstracts\Entities;

use Infrastructure\Exceptions\SetFunctionNotFoundException;

/**
 * Abstract EntityAbstract
 * @package Core\Infrastructure\Abstracts\Entities
 */
abstract class EntityAbstract
{
    /**
     * @param array $arrAttributes
     * @return static
     * @throws SetFunctionNotFoundException
     */
    public function setAttributes(array $arrAttributes): self
    {
        foreach ($arrAttributes as $attr => $val) {
            $attr = ucfirst($attr);
            $functionName = 'set' . $attr;

            if (!method_exists($this, $functionName)) {
                throw new SetFunctionNotFoundException($functionName);
            }

            $this->{$functionName}($val);
        }

        return $this;
    }

    /**
     * @param array $arrAttributes
     * @throws SetFunctionNotFoundException
     * @return static
     */
    public static function createInstanceFromAttributes(array $arrAttributes): self
    {
        $entity = new static();
        $entity->setAttributes($arrAttributes);

        return $entity;
    }
}
