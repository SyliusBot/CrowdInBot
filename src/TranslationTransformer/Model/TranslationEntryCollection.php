<?php


namespace SyliusBot\TranslationTransformer\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryCollection extends ArrayCollection implements TranslationEntryCollectionInterface
{
    /**
     * @var array
     */
    private $domain;

    /**
     * {@inheritdoc}
     */
    public function __construct($domain, array $elements = [])
    {
        $this->domain = $domain;
        
        foreach ($elements as $element) {
            $this->add($element);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add($value)
    {
        if (!$value instanceof TranslationEntryInterface) {
            throw new \InvalidArgumentException("");
        }

        $this->set($value->getKey(), $value);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getByTranslationEntryKey($key)
    {
        return $this->filter(function (TranslationEntryInterface $translationEntry) use ($key) {
            return $key === $translationEntry->getKey();
        })->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getByTranslationEntryValue($value)
    {
        return $this->filter(function (TranslationEntryInterface $translationEntry) use ($value) {
            return $value === $translationEntry->getValue();
        })->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
