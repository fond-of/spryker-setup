<?php

namespace FondOfSpryker\Zed\Setup\Business\Model;

use Spryker\Shared\Config\Environment;
use Spryker\Zed\Setup\Business\Model\Cronjobs as BaseCronjobs;

class Cronjobs extends BaseCronjobs
{
    const DEFAULT_AMOUNT_OF_BUILDS_FOR_LOGFILE_ROTATION = -1;
    const FALLBACK_AMOUNT_OF_DAYS_FOR_LOGFILE_ROTATION = -1;

    /**
     * Get number of builds to keep job output history. Each run is a directory, so we definitely need to keep it clean.
     *
     * @param array $job
     *
     * @return int
     */
    protected function getBuildsToKeep(array $job)
    {
        if (array_key_exists('logrotate_builds', $job) && is_int($job['logrotate_builds'])) {
            return $job['logrotate_builds'];
        }

        return self::DEFAULT_AMOUNT_OF_BUILDS_FOR_LOGFILE_ROTATION;
    }

    /**
     * Render Job description (as XML) for Jenkins API call
     *
     * @todo Move XML snippet to twig template
     *
     * @param array $job
     *
     * @return string
     */
    protected function prepareJobXml(array $job)
    {
        $disabled = ($job['enable'] === true) ? 'false' : 'true';
        $schedule = $this->getSchedule($job);
        $buildsToKeep = $this->getBuildsToKeep($job);
        $daysToKeep = $this->getDaysToKeep($job);

        if ($buildsToKeep !== self::DEFAULT_AMOUNT_OF_BUILDS_FOR_LOGFILE_ROTATION) {
            $daysToKeep = self::FALLBACK_AMOUNT_OF_DAYS_FOR_LOGFILE_ROTATION;
        }

        $command = htmlspecialchars($job['command']);
        $store = $job['store'];

        $xml = "<?xml version='1.0' encoding='UTF-8'?>
<project>
  <actions/>
  <description></description>
  <logRotator>
    <daysToKeep>$daysToKeep</daysToKeep>
    <numToKeep>$buildsToKeep</numToKeep>
    <artifactDaysToKeep>$daysToKeep</artifactDaysToKeep>
    <artifactNumToKeep>$buildsToKeep</artifactNumToKeep>
  </logRotator>
  <keepDependencies>false</keepDependencies>
  <properties/>
  <scm class='hudson.scm.NullSCM'/>
  <canRoam>true</canRoam>
  <disabled>$disabled</disabled>
  <blockBuildWhenDownstreamBuilding>false</blockBuildWhenDownstreamBuilding>
  <blockBuildWhenUpstreamBuilding>false</blockBuildWhenUpstreamBuilding>
  <triggers class='vector'>$schedule</triggers>
  <concurrentBuild>false</concurrentBuild>
  <builders>
    <hudson.tasks.Shell>";

        $xml .= $this->getCommand($command, $store);
        $xml .= "
    </hudson.tasks.Shell>
  </builders>\n"
            . $this->getPublisherString($job) . "\n
  <buildWrappers/>
</project>\n";

        return $xml;
    }

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
