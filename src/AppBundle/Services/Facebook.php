<?php

namespace AppBundle\Services;

class Facebook
{
    private $appID;
    private $appSecret;
    private $defaultGraphVersion;

    public function __construct($appID, $appSecret, $defaultGraphVersion)
    {
        $this->appID =$appID;
        $this->appSecret = $appSecret;
        $this->defaultGraphVersion = $defaultGraphVersion;
    }

    public function connectApps()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => $this->appID,
            'app_secret' => $this->appSecret,
            'default_graph_version' => $this->defaultGraphVersion,
        ]);

        try {
            $token = $fb->getCanvasHelper()->getAccessToken();
        } catch (\Facebook\Exception\FacebookSDKException $e) {
            die();
        }

        if ($token == null) {
            $helper = $fb->getRedirectLoginHelper();
            $scope = ['email', 'user_likes', 'user_photos', 'publish_actions'];
            $loginUrl = $helper->getLoginUrl('https://apps.facebook.com/' . $this->appID, $scope);

            echo '<script>window.top.location.href = "' . $loginUrl . '"</script>';
        } else {
            $fb->setDefaultAccessToken($token);
        }

        return $fb;
    }
}
