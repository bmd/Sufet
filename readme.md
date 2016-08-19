### What is Sufet?
Sufet is a generic, standalone library for implementing server-driven content negotiation that separates the domain logic of content negotiation from its behavioral components to create an extensible framework for negotiating HTTP responses and representations based on any header value, while still creating a semantic interface for doing the types of simpler content negotiation tasks that all web applications need to manage.

Not only that, but it also includes a PSR-7 middleware wrapper to seamlessly integrate content negotiation into your existing framework-driven applications.

### Getting Started
```php
$negotiator = new \Sufet\Sufet::makeNegotiator('accept', 'application/json')

// use the negotiator's methods ...
$negotiator->wants('application/json');   // true
$negotiator->willAccept('text/csv');      // false

// ... or reach directly to invidual media types
$negotiator->best()->isWildCard();        // false
$negotiator->best()->name;                // 'application/json'
```

### Extending Sufet
Although most existing content negotiation libraries are tightly coupled to the idea of negotiating based on specific headers, I was interested in the challenge of expressing content negotiation in a more generic way. 

All negotiable types are represented as an instance of `\Sufet\Entities\ContentType` and all negotiator classes are derived from `\Sufet\Negotiators\AbstractNegotiatior`. 

Because the negotiator factory assumes a consistent mapping between header names and their negotiator, you can extend Sufet by creating your own Negotiator class that extends the `AbstractNegotiator` and then using the `class_alias()` function to move those classes into the `Sufet\Negotiators` namespace. E.g.:
  
```php
<?php // XCustomHeaderNegotiator.php
namespace My\Domain;

use Sufet\Negotiators\AbstractNegotiator;

class XCustomHeaderNegotiator extends AbstractNegotiator
{
    // implementation
}
```

```php
<?php // bootstrap.php

// after autoloader...

class_alias("\\My\\Domain\\XCustomHeaderNegotiator", "\\Sufet\\Negotiators\\XCustomHeaderNegotiator")

\Sufet\Sufet::makeNegotiator('x-custom-header', 'abc123');

```