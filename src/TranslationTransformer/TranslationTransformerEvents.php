<?php

namespace SyliusBot\TranslationTransformer;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class TranslationTransformerEvents
{
    const PRE_MANIPULATION = 'sylius_bot.translation_transformer.pre_manipulation';

    const ENTRY_CHANGE = 'sylius_bot.translation_transformer.entry_change';

    const POST_MANIPULATION = 'sylius_bot.translation_transformer.post_manipulation';
}
