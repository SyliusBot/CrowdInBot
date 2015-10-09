<?php

namespace SyliusBot\Crowdin\Scheduler;

use Crowdin\Api;
use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface SynchronizationSchedulerInterface
{
    /**
     * @param TranslationProviderInterface $localTranslationProvider
     * @param TranslationProviderInterface $crowdinTranslationProvider
     *
     * @return Api\ApiInterface[]
     */
    public function schedule(TranslationProviderInterface $localTranslationProvider, TranslationProviderInterface $crowdinTranslationProvider);
}
