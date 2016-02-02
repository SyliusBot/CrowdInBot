<?php

namespace SyliusBot\TranslationTransformer\Model;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class TranslationEntry implements TranslationEntryInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $domain;

    /**
     * @param string $key
     * @param string $value
     * @param string|null $domain
     */
    public function __construct($key, $value, $domain = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->domain = $domain ?: 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
