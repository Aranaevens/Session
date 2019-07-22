<?php

namespace App\EventListener;
 
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
 
class ResponseListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        // CSP Protection
        // $event->getResponse()->headers->set('Content-Security-Policy', 
        //     'default-src \'self\';
        //     img-src \'self\' https://i.imgur.com;
        //     object-src \'none\';
        //     style-src \'self\' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net/ https://kit-free.fontawesome.com/;
        //     font-src https://kit-free.fontawesome.com/;
        //     script-src \'self\' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net/ https://kit.fontawesome.com/ \'unsafe-inline\';
        //     frame-ancestors \'self\';
        //     base-uri \'self\';
        //     form-action \'self\';'
        // );
        
        // Security Headers
        $event->getResponse()->headers->set('X-XSS-Protection', '1; mode=block');
        $event->getResponse()->headers->set('X-Frame-Options', 'deny');
        $event->getResponse()->headers->set('X-Content-Type-Options', 'nosniff');

        // Caching Rules
        $event->getResponse()->headers->set('Cache-Control', 'no-cache');
        $event->getResponse()->headers->set('Expires', '0');
    }
}