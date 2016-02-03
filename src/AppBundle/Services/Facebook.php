<?php

namespace AppBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\HttpException;
use AppBundle\Entity\DataUserFacebook;
use AppBundle\Entity\LikeFacebook;
use Symfony\Component\HttpFoundation\Session;

class Facebook
{
    private $om;
    private $appID;
    private $appSecret;
    private $defaultGraphVersion;
    private $securityContext;
    private $session;

    public function __construct(ObjectManager $om, $appID, $appSecret, $defaultGraphVersion, $securityContext, $session)
    {
        $this->om = $om;
        $this->appID = $appID;
        $this->appSecret = $appSecret;
        $this->defaultGraphVersion = $defaultGraphVersion;
        $this->securityContext = $securityContext;
        $this->session = $session;
    }

    /**
     * Get User Node
     *
     * @return \Facebook\GraphNodes\GraphUser
     */
    public function getUserNode()
    {
        $fb =$this->connectApps();

        try {
            $response = $fb->get('/me?fields=id,name,email,picture{url},likes');
            $userNode = $response->getGraphUser();
            $this->getUserData($userNode);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            throw new HttpException(
                500,
                'Graph returned an error: ' . $e->getMessage()
            );
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            throw new HttpException(
                500,
                'Facebook SDK returned an error: ' . $e->getMessage()
            );
        }

        $response = $fb->get("/" . $this->appID . "/roles?fields=role,user", $this->appID . '|' . $this->appSecret);
        $rolesNode = $response->getGraphEdge();

        foreach ($rolesNode as $role) {
            foreach ($userNode as $u) {
                if ($u == $role['user']) {
                    if ($role['role'] == "administrators") {
                        $this->session->set('isadmin', true);
                    }
                }
            }
        }

        return $userNode;
    }

    /**
     * Get data user
     *
     * @param $userNode
     */
    private function getUserData($userNode)
    {
        // get or create dataUserFacebook
        $dataUserFacebookRepository = $this->om->getRepository('AppBundle:DataUserFacebook');
        $dataUserFacebook = $dataUserFacebookRepository->find($userNode['id']);
        if (!$dataUserFacebook) {
            $dataUserFacebook = (new DataUserFacebook())
                ->setId($userNode['id'])
                ->setProfilName($userNode['name'])
                ->setEmail($userNode['email'])
                ->setPictureProfilUrl($userNode['picture']['url'])
            ;
            $this->om->persist($dataUserFacebook);
        }

        // get or create likeFacebook AND create link user to like
        $likeFacebookRepository = $this->om->getRepository('AppBundle:LikeFacebook');
        foreach ($userNode['likes'] as $like) {
            $likeFacebook = $likeFacebookRepository->find($like['id']);
            if (!$likeFacebook) {
                $likeFacebook = (new LikeFacebook())
                    ->setId($like['id'])
                    ->setName($like['name'])
                ;
                $this->om->persist($likeFacebook);
            }
            if (!$dataUserFacebook->getLikes($likeFacebook)) {
                $dataUserFacebook->addLike($likeFacebook);
            }
        }

        $this->om->flush();
    }

    /**
     * Connection to facebook application
     *
     * @return \Facebook\Facebook
     */
    private function connectApps()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => $this->appID,
            'app_secret' => $this->appSecret,
            'default_graph_version' => $this->defaultGraphVersion,
        ]);

        try {
            $token = $fb->getCanvasHelper()->getAccessToken();
        } catch (\Facebook\Exception\FacebookSDKException $e) {
            throw new HttpException(
                500,
                'Facebook Access Token returned an error: ' . $e->getMessage()
            );
        }

        if ($token == null) {
            $helper = $fb->getRedirectLoginHelper();
            $scope = ['email', 'user_likes'];
            $loginUrl = $helper->getLoginUrl('https://apps.facebook.com/' . $this->appID, $scope);

            echo '<script>window.top.location.href = "' . $loginUrl . '"</script>';
        } else {
            $fb->setDefaultAccessToken($token);
        }

        return $fb;
    }
}
