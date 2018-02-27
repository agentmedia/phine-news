<?php
namespace Phine\Bundles\News\Logic\Enums;
use Phine\Framework\System\Enum;

/**
 * Describes the placement for article contents contributing to title or meta description
 */
class MetaPlacement extends Enum
{
    /**
     * Prepend article texts to the title or description
     * @return MetaPlacement
     */
    static function Prepend()
    {
        return new self(__FUNCTION__);
    }
    
    /**
     * Append article texts to the title or description
     * @return MetaPlacement
     */
    static function Append()
    {
        return new self(__FUNCTION__);
    }
    
    /**
     * Use article texts only for the title or description
     * @return MetaPlacement
     */
    static function Replace()
    {
        return new self(__FUNCTION__);
    }
    
    
    /**
     * Leave title and description as is
     * @return MetaPlacement
     */
    static function None()
    {
        return new self(__FUNCTION__);
    }
}

