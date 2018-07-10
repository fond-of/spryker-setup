<?php

namespace FondOfSpryker\Zed\Setup\Business\Model;

use Spryker\Shared\Config\Environment;
use Spryker\Zed\Setup\Business\Model\Cronjobs as BaseCronjobs;

class Cronjobs extends BaseCronjobs
{
    /**
     * @param string $command
     * @param string $store
     *
     * @return string
     */
    protected function getCommand($command, $store)
    {
        $environment = Environment::getInstance();
        $environment_name = $environment->getEnvironment();

        return "<command>
export APPLICATION_ENV=$environment_name
export APPLICATION_STORE=$store
cd " . APPLICATION_ROOT_DIR . "
. ./config/Zed/cronjobs/cron.conf
$command</command>";
    }
}
