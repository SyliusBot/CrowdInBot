<?php

namespace SyliusBot\CrowdinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Util\StringUtils;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class GithubHookController extends Controller
{
    public function hookAction(Request $request)
    {
        if (!$request->headers->has('X-Hub-Signature')) {
            throw $this->createAccessDeniedException('No X-Hub-Signature');
        }

        $signature = $request->headers->get('X-Hub-Signature');
        $method = explode('=', $signature, 2)[0];

        if (!in_array($method, hash_algos(), true)) {
            throw $this->createAccessDeniedException('Not supported algo');
        }

        $ourSignature = $method . '='. hash_hmac($method, $request->getContent(), $this->getParameter('github_webhook_secret'));

        if (true !== StringUtils::equals($ourSignature, $signature)) {
            throw $this->createAccessDeniedException('Invalid signature');
        }

        if (isset($payload['action']) && 'push' === $payload['action']) {
            $this->get('sylius_bot.crowdin.synchronizer.up')->synchronize();
        }

        return new Response();
    }
}
