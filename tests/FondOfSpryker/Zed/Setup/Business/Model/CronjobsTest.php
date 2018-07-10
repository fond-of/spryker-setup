<?php

namespace FondOfSpryker\Zed\Setup\Business\Model;

use Codeception\Test\Unit;
use ReflectionClass;
use Spryker\Zed\Setup\SetupConfig;

class CronjobsTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Setup\Business\Model\Cronjobs
     */
    protected $cronjobs;

    /**
     * @var \Spryker\Zed\Setup\SetupConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $setupConfigMock;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->setupConfigMock = $this->getMockBuilder(SetupConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cronjobs = new Cronjobs($this->setupConfigMock);
    }

    /**
     * @return void
     */
    public function testGetCommand()
    {
        $store = 'UNIT';
        $command = '$PHP_BIN vendor/bin/console test:test';

        $reflection = new ReflectionClass(get_class($this->cronjobs));

        $method = $reflection->getMethod('getCommand');
        $method->setAccessible(true);

        $actualCommand = $method->invokeArgs($this->cronjobs, [$command, $store]);
        $expectedCommand = "<command>
export APPLICATION_ENV=" . APPLICATION_ENV . "
export APPLICATION_STORE=$store
cd " . APPLICATION_ROOT_DIR . "
. ./config/Zed/cronjobs/cron.conf
$command</command>";

        $this->assertEquals($expectedCommand, $actualCommand);
    }
}
