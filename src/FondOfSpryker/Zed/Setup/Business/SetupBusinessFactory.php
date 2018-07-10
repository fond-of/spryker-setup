<?php

namespace FondOfSpryker\Zed\Setup\Business;

use FondOfSpryker\Zed\Setup\Business\Model\Cronjobs;
use Spryker\Zed\Setup\Business\SetupBusinessFactory as BaseSetupBusinessFactory;

class SetupBusinessFactory extends BaseSetupBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\Setup\Business\Model\Cronjobs
     */
    public function createModelCronjobs()
    {
        $config = $this->getConfig();

        return new Cronjobs($config);
    }
}
