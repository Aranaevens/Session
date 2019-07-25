<?php

namespace App\EventListener;
 
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
 
class ResponseListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        // CSP Protection
        // Definit les sources autorisées sur l'application
        $event->getResponse()->headers->set('Content-Security-Policy', 
            'default-src \'self\';
            img-src \'self\' https://i.imgur.com;
            object-src \'none\';
            style-src \'self\' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net/ https://kit-free.fontawesome.com/ \'unsafe-inline\';
            font-src https://kit-free.fontawesome.com/ \'self\' data:;
            script-src \'self\' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net/ https://kit.fontawesome.com/;
            frame-ancestors \'self\';
            base-uri \'self\';
            form-action \'self\';'
        );
        
        // Security Headers

        // Sécurité supplémentaire contre le cross-site scripting
        $event->getResponse()->headers->set('X-XSS-Protection', '1; mode=block');
        // Empêche d'i-framer le site pour éviter de faux clones / la fuite d'informations
        $event->getResponse()->headers->set('X-Frame-Options', 'deny');
        // Fait respecter les MIME (Nature et Format du document, ici, souvent HTML)
        $event->getResponse()->headers->set('X-Content-Type-Options', 'nosniff');

        // Caching Rules

        // Enlève le cache
        $event->getResponse()->headers->set('Cache-Control', 'no-cache');
        $event->getResponse()->headers->set('Expires', '0');

        // HSTS
        // Ici commentée car le site ne marche pas en HTTPS en local
        // $event->getResponse()->headers->set('Strict-Transport-Security', 'max-age=3600');
    }
}