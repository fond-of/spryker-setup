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
    protected function _before(): void
    {
        $this->setupConfigMock = $this->getMockBuilder(SetupConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cronjobs = new Cronjobs($this->setupConfigMock);
    }

    /**
     * @return void
     */
    public function testPrepareJobXmlWithDaysToKeep(): void
    {
        $expectedXml = "<?xml version='1.0' encoding='UTF-8'?>
<project>
  <actions/>
  <description></description>
  <logRotator>
    <daysToKeep>5</daysToKeep>
    <numToKeep>-1</numToKeep>
    <artifactDaysToKeep>5</artifactDaysToKeep>
    <artifactNumToKeep>-1</artifactNumToKeep>
  </logRotator>
  <keepDependencies>false</keepDependencies>
  <properties/>
  <scm class='hudson.scm.NullSCM'/>
  <canRoam>true</canRoam>
  <disabled>false</disabled>
  <blockBuildWhenDownstreamBuilding>false</blockBuildWhenDownstreamBuilding>
  <blockBuildWhenUpstreamBuilding>false</blockBuildWhenUpstreamBuilding>
  <triggers class='vector'></triggers>
  <concurrentBuild>false</concurrentBuild>
  <builders>
    <hudson.tasks.Shell><command>
export APPLICATION_ENV=" . APPLICATION_ENV . "
export APPLICATION_STORE=UNIT
cd " . APPLICATION_ROOT_DIR . "
. ./config/Zed/cronjobs/cron.conf
\$PHP_BIN vendor/bin/console product-label:relations:update -vvv</command>
    </hudson.tasks.Shell>
  </builders>
<publishers/>

  <buildWrappers/>
</project>\n";

        $job = [
            'name' => 'update-product-label-relations',
            'command' => '$PHP_BIN vendor/bin/console product-label:relations:update -vvv',
            'schedule' => '',
            'enable' => true,
            'run_on_non_production' => true,
            'logrotate_days' => 5,
            'store' => 'UNIT',
        ];

        $reflection = new ReflectionClass(get_class($this->cronjobs));

        $method = $reflection->getMethod('prepareJobXml');
        $method->setAccessible(true);

        $actualXml = $method->invokeArgs($this->cronjobs, [$job]);
        $this->assertEquals($expectedXml, $actualXml);
    }

    /**
     * @return void
     */
    public function testPrepareJobXmlWithBuildsToKeep(): void
    {
        $expectedXml = "<?xml version='1.0' encoding='UTF-8'?>
<project>
  <actions/>
  <description></description>
  <logRotator>
    <daysToKeep>-1</daysToKeep>
    <numToKeep>20</numToKeep>
    <artifactDaysToKeep>-1</artifactDaysToKeep>
    <artifactNumToKeep>20</artifactNumToKeep>
  </logRotator>
  <keepDependencies>false</keepDependencies>
  <properties/>
  <scm class='hudson.scm.NullSCM'/>
  <canRoam>true</canRoam>
  <disabled>false</disabled>
  <blockBuildWhenDownstreamBuilding>false</blockBuildWhenDownstreamBuilding>
  <blockBuildWhenUpstreamBuilding>false</blockBuildWhenUpstreamBuilding>
  <triggers class='vector'></triggers>
  <concurrentBuild>false</concurrentBuild>
  <builders>
    <hudson.tasks.Shell><command>
export APPLICATION_ENV=" . APPLICATION_ENV . "
export APPLICATION_STORE=UNIT
cd " . APPLICATION_ROOT_DIR . "
. ./config/Zed/cronjobs/cron.conf
\$PHP_BIN vendor/bin/console product-label:relations:update -vvv</command>
    </hudson.tasks.Shell>
  </builders>
<publishers/>

  <buildWrappers/>
</project>\n";

        $job = [
            'name' => 'update-product-label-relations',
            'command' => '$PHP_BIN vendor/bin/console product-label:relations:update -vvv',
            'schedule' => '',
            'enable' => true,
            'run_on_non_production' => true,
            'logrotate_builds' => 20,
            'logrotate_days' => 7,
            'store' => 'UNIT',
        ];

        $reflection = new ReflectionClass(get_class($this->cronjobs));

        $method = $reflection->getMethod('prepareJobXml');
        $method->setAccessible(true);

        $actualXml = $method->invokeArgs($this->cronjobs, [$job]);
        $this->assertEquals($expectedXml, $actualXml);
    }

    /**
     * @return void
     */
    public function testPrepareJobXmlWithPriority(): void
    {
        $expectedXml = "<?xml version='1.0' encoding='UTF-8'?>
<project>
  <actions/>
  <description></description>
  <logRotator>
    <daysToKeep>-1</daysToKeep>
    <numToKeep>20</numToKeep>
    <artifactDaysToKeep>-1</artifactDaysToKeep>
    <artifactNumToKeep>20</artifactNumToKeep>
  </logRotator>
  <keepDependencies>false</keepDependencies>
  <properties/>
  <scm class='hudson.scm.NullSCM'/>
  <canRoam>true</canRoam>
  <disabled>false</disabled>
  <blockBuildWhenDownstreamBuilding>false</blockBuildWhenDownstreamBuilding>
  <blockBuildWhenUpstreamBuilding>false</blockBuildWhenUpstreamBuilding>
  <triggers class='vector'></triggers>
  <concurrentBuild>false</concurrentBuild>
  <builders>
    <hudson.tasks.Shell><command>
export APPLICATION_ENV=" . APPLICATION_ENV . "
export APPLICATION_STORE=UNIT
cd " . APPLICATION_ROOT_DIR . "
. ./config/Zed/cronjobs/cron.conf
\$PHP_BIN vendor/bin/console product-label:relations:update -vvv</command>
    </hudson.tasks.Shell>
  </builders>
<publishers/>

  <buildWrappers/>
</project>\n";

        $job = [
            'name' => 'update-product-label-relations',
            'command' => '$PHP_BIN vendor/bin/console product-label:relations:update -vvv',
            'schedule' => '',
            'enable' => true,
            'run_on_non_production' => true,
            'logrotate_builds' => 20,
            'store' => 'UNIT',
        ];

        $reflection = new ReflectionClass(get_class($this->cronjobs));

        $method = $reflection->getMethod('prepareJobXml');
        $method->setAccessible(true);

        $actualXml = $method->invokeArgs($this->cronjobs, [$job]);
        $this->assertEquals($expectedXml, $actualXml);
    }

    /**
     * @return void
     */
    public function testGetCommand(): void
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
