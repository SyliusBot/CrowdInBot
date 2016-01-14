<?php

namespace SyliusBot\CrowdinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class GithubHookController extends Controller
{
    public function hookAction(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        if (!isset($payload['hook']['config']['secret'])) {
            throw $this->createNotFoundException();
        }

        if ($this->getParameter('github_webhook_secret') !== $payload['hook']['config']['secret']) {
            throw $this->createAccessDeniedException();
        }

        $this->get('sylius_bot.crowdin.synchronizer.up')->synchronize();

        return new Response();
    }
}
