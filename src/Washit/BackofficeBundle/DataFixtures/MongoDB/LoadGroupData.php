<?php

namespace Washit\BackofficeBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use OpenOrchestra\ModelInterface\DataFixtures\OrchestraProductionFixturesInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of LoadGroupData
 */
class LoadGroupData extends AbstractFixtureData implements OrderedFixtureInterface, OrchestraProductionFixturesInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $group = $this->getReference('group2');
        $group->setName('Ffgym admin group');
        $group->addLabel($this->generateTranslatedValue('fr', 'Groupe d\'admnistration Ffgym'));
        $group->addLabel($this->generateTranslatedValue('en', 'Ffgym admin group'));
        $group->setSite($this->getReference('siteFfgym'));
        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 670;
    }
}