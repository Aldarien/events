# Events

[WebSockets] app for PHP. Using [Ratchet] as a base for creating the **app** it can be used as **framework** for connecting to the database from the web **UI**.

## Introduction

I wrote this project because I had a hard time finding any alternative to handling Server-Side WebSocket with [PHP]. [Ratchet] handles the connection but not the **app** itself. I needed an app structure similar to [Slim] which was what I work with. This is the result.

## Installation

Use [composer].

```
composer require aldarien/events
```

## Use

I recommend you setup your **app** with a Container like [PHP-DI]

*Base example*:

```
$app = ProVM\Common\Alias\Server\App::factory(
  new Ratchet\Server\HttpServer(
    new Ratchet\Server\WsServer(
      new ProVM\Common\Alias\Event\Message(new SplObjectStorage())
    )
  ),
  $port ?? 8010
);
$app->add('event_name', function($request, $response) {
  // do action
  return $response;
})
$app->run();
```

*Breakdown*:

The **app** is created similar to [Ratchet] with the wrapper `ProVM\Common\Alias\Server\App` but the message handler is from this package `ProVM\Common\Alias\Event\Message` which handles all event dispatches and listeners.

Then the event(s) are added with `$app->add` it requires a name for the event and a callable handler that work similar to [Slim] Controllers.

Finally just `$app->run`

You can use a **Listener** for the callable:

```
class Handler {
  public function __invoke($request, $response) {
    // do something else
    return $response;
  }
  public function other($request, $response) {
    // other action
    return $response;
  }
}
$app->add('event2', new Handler());
$app->add('other', [new Handler(), 'other']);
```

In the web **UI** just create a websocket:

```
var conn = new WebSocket(websocket_url)
conn.onopen = function(e) {
  // open event
}
conn.onmessage = function(e) {
  // listen to messages received
}
conn.onerror = function(e) {
  console.error(e)
}
conn.onclose = function(e) {
  // check if e.code == 1000 closed without error)
}
msg = {
  action: 'event_name',
  data: []
}
conn.send(JSON.stringify(msg))
```

*Breakdown*:

Create the websocket connection `new WebSocket(websocket_url)` where `websocket_url` can be something like `ws://localhost:8010` or `wss://localhost:8010` where the port is the same one set in the app.

Set the event listeners for `open`, `message`, `error` and `close` and start sending messages with `send`

Take note of the last lines where the message received by the **app** needs an action equivalent to the event names added before and the data associated if any (can be missing).

[PHP]: http://php.net
[WebSockets]: https://en.wikipedia.org/wiki/WebSocket
[Ratchet]: http://socketo.me/
[Slim]: https://slimframework.com
[PHP-DI]: https://php-di.org/
[composer]: https://getcomposer.org
