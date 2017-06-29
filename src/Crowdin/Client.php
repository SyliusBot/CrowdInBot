<?php

declare(strict_types=1);

namespace SyliusBot\Crowdin;

use Crowdin\Client as BaseClient;

final class Client extends BaseClient
{
    /**
     * {@inheritdoc}
     */
    public function getHttpClient()
    {
        $httpClient = parent::getHttpClient();

        // Hello abandoned packages, here we meet again!
        $httpClient->setBaseUrl('https://api.crowdin.com/api');

        return $httpClient;
    }
}
