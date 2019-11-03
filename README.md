# INTRODUCTION
Support for elastic confirmation operations in system, such as, registration user, changing password, etc..
# INSTALLATION
`composer require dawid-bednarz/sf-confirmation-bundle`

####1. Create entities file
```php
namespace App\Entity\Token;

use DawBed\ConfirmationBundle\Entity\AbstractToken;

class Token extends AbstractToken
{

}
```
# CONFIGURATION
Add file in config/packages/confirmation_bundle.yaml and define your type of tokens
```yaml
dawbed_confirmation_bundle:
    entities:
        DawBed\ConfirmationBundle\Entity\AbstractToken: App\Entity\Token
    token_types:
          - 'user-confirm-acdcount'
```
Pre definition of token types is for avoid unconscious duplication.
# CREATE TOKEN
for create token dispatch generate event
```php
$generateTokenEvent = new GenerateTokenEvent(new DateInterval('P1D'), 'user-confirm-account');
$this->eventDispatcher->dispatch($generateTokenEvent);
```
first param is time expire, second is type. After dispatching you will get token entity
```php
$tokenEntity = $generateTokenEvent->getToken();
```
# CONSUME TOKEN
For handle consume token add listener to you configuration file.
```yaml
    App\EventListener\ConfirmAccount\AcceptListener:
        tags:
            - { name: kernel.event_listener, event: token.accept_user-confirm-account } # user-confirm-account is your custom defined token type
    App\EventListener\ConfirmAccount\ErrorListener:
        tags:
            - { name: kernel.event_listener, event: token.accept.error_user-confirm-account } # user-confirm-account is your custom defined token type
```
```php
class AcceptListener
{

    function __invoke(AcceptEvent $event)
    {
        $response = new Response();
        // do sth
        $event->setResponse($response
    }
}
class ErrorListener
{
    function __invoke(ErrorEvent $event): void
    {
        $response = new Response();

        if ($event->isConsumed()) {
            $response->setContent('...');
        } elseif ($event->isExpired()) {
            $response->setContent('...');
        }
        $event->setResponse($response);
    }
}
```