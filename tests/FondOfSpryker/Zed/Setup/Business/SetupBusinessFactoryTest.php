<?php

namespace FondOfSpryker\Zed\Setup\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Setup\Business\Model\Cronjobs;
use Spryker\Zed\Setup\SetupConfig;

class SetupBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Setup\Business\SetupBusinessFactory
     */
    protected $setupBusinessFactory;

    /**
     * @var \Spryker\Zed\Setup\SetupConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $setupConfigMock;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->setupBusinessFactory = new SetupBusinessFactory();

        $this->setupConfigMock = $this->getMockBuilder(SetupConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->setupBusinessFactory->setConfig($this->setupConfigMock);
    }

    /**
     * @return void
     */
    public function testCreateModelCronjobs()
    {
        $modelCronjobs = $this->setupBusinessFactory->createModelCronjobs();
        $this->assertInstanceOf(Cronjobs::class, $modelCronjobs);
    }
}
