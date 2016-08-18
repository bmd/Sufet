### What is Sufet?
Sufet is a generic, standalone library for implementing server-driven content negotiation that separates the domain logic of content negotiation from its behavioral components to create an extensible framework for negotiating HTTP responses and representations based on any header value.

Not only that, but it also includes a PSR-7 middleware wrapper to seamlessly integrate content negotiation into your existing framework-driven applications.

### Getting Started
```php
$negotiator = new \Sufet\Sufet::makeNegotiator('accept', 'application/json')
$negotiator->wants('application/json'); // true
$negotiator->willAccept('text/csv');    // false
$negotiator->isWildCard();              // false

$negotiator->best()->name;              // 'application/json'
```

### Extending Sufet
Although most existing content negotiation libraries are tightly coupled to the idea of negotiating based on specific headers, I was interested in the challenge of expressing content negotiation in a 