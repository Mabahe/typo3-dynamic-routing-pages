<?php
declare(strict_types=1);

namespace Smic\DynamicRoutingPages\Event;

class AfterAllSiteConfigurationLoadedFromFilesEvent
{
    protected array $siteConfiguration;

    /**
     * @param array $siteConfiguration
     */
    public function __construct(array $siteConfiguration)
    {
        $this->siteConfiguration = $siteConfiguration;
    }

    /**
     * @return array
     */
    public function getSiteConfiguration(): array
    {
        return $this->siteConfiguration;
    }

    /**
     * @param array $siteConfiguration
     */
    public function setSiteConfiguration(array $siteConfiguration): void
    {
        $this->siteConfiguration = $siteConfiguration;
    }
}
