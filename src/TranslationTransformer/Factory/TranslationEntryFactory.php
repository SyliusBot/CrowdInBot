<?php


namespace SyliusBot\TranslationTransformer\Factory;

use SyliusBot\TranslationTransformer\Model\TranslationEntry;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class TranslationEntryFactory implements TranslationEntryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create($key, $value, $domain = null)
    {
        return new TranslationEntry($key, $value, $domain);
    }

    /**
     * {@inheritdoc}
     */
    public function createFromString($string)
    {
        $translationEntryRegexp = '\(?:((?P<domain>[a-zA-z_]+)\) )?\[(?P<key>[a-z0-9_\.]+)\] "(?P<value>[^"]*)"';

        if (false === (bool) preg_match($translationEntryRegexp, $string, $matches)) {
            throw new \InvalidArgumentException(sprintf(
                'Could not match "%s" by regular expression "%s"',
                $string,
                $translationEntryRegexp
            ));
        }

        $matches['domain'] = isset($matches['domain']) ? $matches['domain'] : null;

        return $this->create($matches['key'], $matches['value'], $matches['domain']);
    }
}
