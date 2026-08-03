# MCP

Extends [`laravel/mcp`](https://github.com/laravel/mcp) so that MCP primitives (tools,
resources, & prompts) can be registered dynamically to servers. These are ordinary
`laravel/mcp` servers — this package just adds a shared registrar and a base `Server` to
build on.

## Usage

### Defining a server

Extend the base `Server`:

```php
use Mcp\Servers\Server;

class Support extends Server
{
    protected string $name = 'Support';
}
```

### Exposing a server

`local()` and `web()` default the handle/route to the kebab-cased class basename:

```php
Support::local();           // handle "support"
Support::local('helpdesk'); // or your own handle

Support::web();             // route "support", returns the Route
Support::web('helpdesk');   // or your own route
```

### Adding primitives

Any package can add primitives to a server — even one it doesn't own — from a service
provider:

```php
Support::add(SearchTickets::class);
Support::add(SearchTickets::class, KnowledgeBase::class, DraftReply::class);
```

`add()` variadically accepts `laravel/mcp` `Tool`, `Resource`, or `Prompt` — as
class-strings or instances.
