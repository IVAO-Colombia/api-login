<?php

namespace IvaoSocialite;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Provider;

class IvaoProvider implements Provider
{
    private const IVAO_LOGIN_REDIRECT_URL = "https://login.ivao.aero/index.php";
    private $redirectUrl;
    private $request;
    private $httpClient;

    public function __construct(Request $request, UserDataHttpClient $httpClient, string $redirectUrl)
    {
        $this->request = $request;
        $this->httpClient = $httpClient;
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Redirect the user of the application to the IVAO's Login Page.
     *
     * @return RedirectResponse
     */
    public function redirect()
    {
        return new RedirectResponse(self::IVAO_LOGIN_REDIRECT_URL . "?url=" . $this->redirectUrl);
    }

    /**
     * Get the User instance for the authenticated user.
     *
     * @return \Laravel\Socialite\Contracts\User
     */
    public function user()
    {
        $rawUserData = $this->httpClient->getUserFromToken($this->extractTokenFromUrl());

        return $rawUserData ? new User($rawUserData) : null;
    }

    private function extractTokenFromUrl()
    {
        return $this->request->input('IVAOTOKEN');
    }
}