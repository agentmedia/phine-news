<?php

namespace Phine\Bundles\News;
use Phine\Bundles\Core\Logic\Bundle\BundleManifest;
use Phine\Bundles\Core\Logic\Bundle\BundleManufacturer;
use Phine\Bundles\Core\Logic\Bundle\BundleDependency;
use Phine\Bundles\Core;

/**
 * The news bundle manifest
 */
class Manifest extends BundleManifest
{
    
    /**
     * The core manifest just to retrieve manufacturer infos
     * @var type 
     */
    private $core;
    
    /**
     * Creates the manifest
     */
    public function __construct()
    {
        $this->core = new Core\Manifest();
    }
    /**
     * The version
     * @return string Returns the bundle version
     */
    public function Version()
    {
        return '1.0.1';
    }
    
    /**
     * Loads extra code not available by autoload
     */
    protected function LoadBackendCode()
    {
        //Nothing yet
    }
    
    /**
     * Gets the bundle manufacturer
     * @return BundleManufacturer Returns the manufacturer of the forms bundle
     */
    public function Manufacturer()
    {
        return $this->core->Manufacturer();
    }

    public function Dependencies()
    {
        return array(new BundleDependency('Core', '1.2.2', '1.2.3'), 
            new BundleDependency('BuiltIn', '1.0.2', '1.0.4'));
    }
    
    
    protected function LoadFrontendCode()
    {
        //Nothing here, yet
    }

}

