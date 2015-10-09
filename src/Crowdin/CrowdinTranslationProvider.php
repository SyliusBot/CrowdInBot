<?php

namespace SyliusBot\Crowdin;

use Crowdin\Api;
use Crowdin\Client;
use SyliusBot\Crowdin\Factory\TranslationFactoryInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class CrowdinTranslationProvider implements TranslationProviderInterface
{
    /**
     * @var Client
     */
    private $crowdinClient;

    /**
     * @var ProjectInformationParserInterface
     */
    private $projectInformationParser;

    /**
     * @var TranslationFactoryInterface
     */
    private $translationFactory;

    /**
     * @param TranslationFactoryInterface $translationFactory
     * @param ProjectInformationParserInterface $projectInformationParser
     * @param Client $crowdinClient
     */
    public function __construct(
        TranslationFactoryInterface $translationFactory,
        ProjectInformationParserInterface $projectInformationParser,
        Client $crowdinClient
    ) {
        $this->translationFactory = $translationFactory;
        $this->projectInformationParser = $projectInformationParser;
        $this->crowdinClient = $crowdinClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslations()
    {
        /** @var Api\Info $info */
        $info = $this->crowdinClient->api('info');
        $data = $info->execute();

        $paths = $this->projectInformationParser->getTranslationsPaths($data);

        $translations = [];
        foreach ($paths as $path) {
            $translations[] = $this->translationFactory->createFromCrowdinPath($path);
        }

        return $translations;
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectories()
    {
        /** @var Api\Info $info */
        $info = $this->crowdinClient->api('info');
        $data = $info->execute();

        return $this->projectInformationParser->getExistingDirectories($data);
    }
}
