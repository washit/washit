<?php

namespace Washit\BackofficeBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\ModelBundle\Document\Site;
use OpenOrchestra\ModelInterface\DataFixtures\OrchestraProductionFixturesInterface;
use OpenOrchestra\ModelInterface\Event\SiteEvent;
use OpenOrchestra\ModelInterface\SiteEvents;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use OpenOrchestra\ModelBundle\DataFixtures\MongoDB\LoadSiteData as BaseLoadSiteData;

/**
 * Description of LoadSiteData
 */
class LoadSiteData extends BaseLoadSiteData implements OrderedFixtureInterface, OrchestraProductionFixturesInterface, ContainerAwareInterface
{
    protected $container;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $site = $this->getReference('site2');
        $site->setDeleted(true);
        $siteFfgym = $this->getSiteFfgym();
        $this->setReference('siteFfgym', $siteFfgym);
        $manager->persist($siteFfgym);
        $manager->flush();
        $event = new SiteEvent($siteFfgym);
        $this->container->get('event_dispatcher')->dispatch(SiteEvents::SITE_CREATE, $event);
    }

    /**
     * @return Site
     */
    protected function getSiteFfgym()
    {
        $siteFfgym = new Site();
        $siteFfgym->setSiteId('washit');
        $siteFfgym->setName('Washit website');
        $this->addSitesAliases(
            array('wash.dev'),
            array('fr'),
            $siteFfgym);
        $siteFfgym->setSitemapPriority(0.5);
        $siteFfgym->setDeleted(false);
        $siteFfgym->setTheme($this->getReference('themePresentation'));

        return $siteFfgym;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 350;
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
