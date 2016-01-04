<?php

namespace Washit\BackofficeBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use OpenOrchestra\ModelInterface\DataFixtures\OrchestraProductionFixturesInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\ModelBundle\Document\Area;
use OpenOrchestra\ModelBundle\Document\Template;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadDefaultTemplateData
 */
class LoadDefaultTemplateData extends AbstractFixture implements OrderedFixtureInterface, OrchestraProductionFixturesInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $defaultTemplate = new Template();
        $defaultTemplate->setTemplateId('default_template');
        $defaultTemplate->setSiteId('ffgym');
        $defaultTemplate->setVersion(1);
        $defaultTemplate->setName('Gabarit par défaut');
        $defaultTemplate->setLanguage('fr');
        $defaultTemplate->setDeleted(false);
        $defaultTemplate->setBoDirection('v');

        $defaultTemplate->addArea(
            $this->createArea('header-section', 'En-tête de page')
        );
        $defaultTemplate->addArea(
            $this->createArea('body-section', 'Corps de page')
        );
        $defaultTemplate->addArea(
            $this->createArea('footer-section', 'Pied de page')
        );

        $this->setReference('default_template', $defaultTemplate);

        $manager->persist($defaultTemplate);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 400;
    }

    /**
     * @return Area
     */
    protected function createArea($areaId, $label, $htmlClass = null, $boDirection = 'v')
    {
        $area = new Area();
        $area->setLabel($label);
        $area->setAreaId($areaId);
        $area->setHtmlClass($htmlClass);
        $area->setBoDirection($boDirection);

        return $area;
    }
}