<?php

namespace Washit\BackofficeBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use OpenOrchestra\ModelBundle\Document\FieldOption;
use OpenOrchestra\ModelBundle\Document\TranslatedValue;
use OpenOrchestra\ModelBundle\Document\FieldType;

/**
 * Class AbstractFixture
 */
abstract class AbstractFixtureData extends AbstractFixture
{
    /**
     * Generate a translatedValue
     *
     * @param string $language
     * @param string $value
     *
     * @return TranslatedValue
     */
    protected function generateTranslatedValue($language, $value)
    {
        $label = new TranslatedValue();
        $label->setLanguage($language);
        $label->setValue($value);

        return $label;
    }

    /**
     * Generate a field option
     *
     * @param string                   $key
     * @param string|int|array|boolean $value
     *
     * @return FieldOption
     */
    protected function generateOption($key, $value)
    {
        $option = new FieldOption();
        $option->setKey($key);
        $option->setValue($value);

        return $option;
    }

    /**
     * @param array   $labelsByLanguages
     * @param boolean $required
     *
     * @return FieldType
     */
    protected function generateFieldDescription(array $labelsByLanguages = array(), $required)
    {
        $requiredOption = $this->generateOption('required', $required);

        $description = new FieldType();
        $description->setFieldId('Description');
        $description->setDefaultValue('');
        $description->setSearchable(false);
        $description->setType('textarea');
        $description->addOption($requiredOption);

        foreach ($labelsByLanguages as $key => $label) {
            $description->addLabel($this->generateTranslatedValue($key, $label));
        }

        return $description;
    }
}