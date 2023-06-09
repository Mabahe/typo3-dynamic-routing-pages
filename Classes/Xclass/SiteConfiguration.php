<?php
declare(strict_types=1);
namespace Smic\DynamicRoutingPages\Xclass;

use Psr\EventDispatcher\EventDispatcherInterface;
use Smic\DynamicRoutingPages\Event\AfterAllSiteConfigurationLoadedFromFilesEvent;
use TYPO3\CMS\Core\Cache\Frontend\PhpFrontend;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @see https://forge.typo3.org/issues/92778
 * The original SiteConfiguration has no possibility for extensions to modify the configuration.
 * That's why we need to xclass it.
 */
class SiteConfiguration extends \TYPO3\CMS\Core\Configuration\SiteConfiguration
{
    protected PhpFrontend $cache;

    public function __construct(string $configPath, PhpFrontend $coreCache = null)
    {
        parent::__construct($configPath);
        if (!isset($this->cache)) {
            $this->cache = GeneralUtility::getContainer()->get('cache.core');
        }
    }

    protected function getAllSiteConfigurationFromFiles(bool $useCache = true): array
    {
        $siteConfiguration = $useCache ? $this->cache->require($this->cacheIdentifier) : false;
        if ($siteConfiguration !== false) {
            return $siteConfiguration;
        }
        $siteConfiguration = parent::getAllSiteConfigurationFromFiles($useCache);
        $eventDispatcher = GeneralUtility::getContainer()->get(EventDispatcherInterface::class);
        /** @var AfterAllSiteConfigurationLoadedFromFilesEvent $event */
        $event = $eventDispatcher->dispatch(
            new AfterAllSiteConfigurationLoadedFromFilesEvent($siteConfiguration)
        );
        $siteConfiguration = $event->getSiteConfiguration();
        $this->cache->set($this->cacheIdentifier, 'return ' . var_export($siteConfiguration, true) . ';');

        return $siteConfiguration;
    }
}
