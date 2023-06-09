<?php
declare(strict_types=1);

namespace Smic\DynamicRoutingPages\EventListener;

use Smic\DynamicRoutingPages\ConfigurationModifier;
use Smic\DynamicRoutingPages\Event\AfterAllSiteConfigurationLoadedFromFilesEvent;

class SiteConfigurationListener
{
    public function modifyConfiguration(AfterAllSiteConfigurationLoadedFromFilesEvent $event): void
    {
        $configuration = $event->getSiteConfiguration();
        $configuration = ConfigurationModifier::modifyConfiguration($configuration);
        $event->setSiteConfiguration($configuration);
    }
}
