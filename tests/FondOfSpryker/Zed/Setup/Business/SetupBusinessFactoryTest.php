<?php

namespace FondOfSpryker\Zed\Setup\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Setup\Business\Model\Cronjobs;
use org\bovigo\vfs\vfsStream;

class SetupBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Setup\Business\SetupBusinessFactory
     */
    protected $setupBusinessFactory;

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $vfsStreamDirectory;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->setupBusinessFactory = new SetupBusinessFactory();

        $this->vfsStreamDirectory = vfsStream::setup('root', null, [
            'config' => [
                'Shared' => [
                    'stores.php' => file_get_contents(codecept_data_dir('stores.php')),
                    'config_default.php' => file_get_contents(codecept_data_dir('config_default.php')),
                ],
            ],
        ]);
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
