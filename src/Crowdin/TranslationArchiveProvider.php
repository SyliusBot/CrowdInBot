<?php

namespace SyliusBot\Crowdin;

use Crowdin\Api;
use Crowdin\Client;
use SyliusBot\ArchiveFactoryInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class TranslationArchiveProvider implements TranslationArchiveProviderInterface
{
    /**
     * @var Client
     */
    private $crowdinClient;

    /**
     * @var ArchiveFactoryInterface
     */
    private $archiveFactory;

    /**
     * @param Client $crowdinClient
     * @param ArchiveFactoryInterface $archiveFactory
     */
    public function __construct(Client $crowdinClient, ArchiveFactoryInterface $archiveFactory)
    {
        $this->crowdinClient = $crowdinClient;
        $this->archiveFactory = $archiveFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getArchive()
    {
        $this->crowdinClient->api('export')->execute();

        /** @var Api\Download $download */
        $download = $this->crowdinClient->api('download');
        $download->setCopyDestination('/tmp');
        $download->setPackage('all.zip');
        $download->execute();

        return $this->archiveFactory->createArchive('/tmp/all.zip');
    }
}
