<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $router;
    private $authChecker;
    
    public function __construct(RouterInterface $router, AuthorizationCheckerInterface $authChecker)
    {
        $this->router = $router;
        $this->authChecker = $authChecker;
    }
    
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $request->getSession()->getFlashbag()->add('notice', 'Accès refusé, veuillez vous connecter avec un compte possédant les autorisations nécessaires.');
        if ($this->authChecker->isGranted('ROLE_USER'))
        {
            $url = $this->router->generate('home');
        }
        else
        {
            $url = $this->router->generate('app_login');
        }

        return new RedirectResponse($url);
    }
}