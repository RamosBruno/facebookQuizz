<?php

namespace AppBundle\Menu\Voter;

use Symfony\Component\HttpFoundation\Request;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Knp\Menu\ItemInterface;

class RequestVoter implements VoterInterface
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param ItemInterface $item
     *
     * @return bool
     */
    public function matchItem(ItemInterface $item)
    {
        $requestUri = $this->request->getRequestUri();
        $baseUrl = $this->request->getBaseUrl().'/';
        $uri = $item->getUri();
        if ($uri === $requestUri) {
            return true;
        } else if($uri !== $baseUrl && (substr($requestUri, 0, strlen($uri)) === $uri)) {
            return true;
        }

        return null;
    }
}
