<?php

namespace Washit\BackofficeBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use OpenOrchestra\ModelInterface\DataFixtures\OrchestraProductionFixturesInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\ModelBundle\Document\Node;
use OpenOrchestra\ModelBundle\Document\Template;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use OpenOrchestra\ModelInterface\Model\NodeInterface;

/**
 * Class LoadNodeRootData
 */
class LoadNodeRootData extends AbstractFixture implements OrderedFixtureInterface, OrchestraProductionFixturesInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $routePattern = "/";
        $language = "fr";

        $node = new Node();
        $node->setMaxAge(1000);
        $node->setNodeType(NodeInterface::TYPE_DEFAULT);
        $siteId = $this->getReference('siteFfgym')->getSiteId();
        $node->setSiteId($siteId);
        $node->setPath('-');
        $node->setVersion(1);
        $status = $this->getReference('status-published');
        $node->setStatus($status);
        $node->setDeleted(false);

        $node->setTheme('themePresentation');
        $node->setLanguage('fr');
        $node->setNodeId(NodeInterface::ROOT_NODE_ID);
        $node->setName('HomepageFFGYM');
        $node->setCreatedBy('admin');
        $node->setParentId('-');
        $node->setOrder(0);
        $node->setInMenu(true);
        $node->setRoutePattern($routePattern);
        $node->setLanguage($language);

        $this->assignTemplateToNode($node, $this->getReference('default_template'));

        $manager->persist($node);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 680;
    }

    /**
     * Assign a template to a node. Blocks and areas are copied from template to node.
     *
     * @param Node $node
     * @param Template $template
     *
     * @return void
     */
    protected function assignTemplateToNode(Node $node, Template $template)
    {
        $node->setTemplateId($template->getTemplateId());
        $node->setAreas($template->getAreas());
    }
}
