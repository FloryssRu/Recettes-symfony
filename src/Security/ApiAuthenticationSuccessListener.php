<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiAuthenticationSuccessListener
{
    public function onLexikJwtAuthenticationOnAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user || !in_array('ROLE_API', $user->getRoles(), true)) {
            // Retourne une réponse JSON formatée pour l'erreur 403
            $response = [
                'title' => 'An error occurred',
                'detail' => 'Access Denied.',
                'status' => JsonResponse::HTTP_FORBIDDEN,
                'type' => '/errors/403',
            ];

            $event->setData($response);
            return;
        }

        // If the user has the role, the token is generated normally.
        $event->setData($data);
    }
}
