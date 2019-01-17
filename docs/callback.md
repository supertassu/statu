# Home callback

Statu supports "if a server does not call home every 10 minutes assuming it is dead"-checking.

## Getting started

Make sure you have a cron job for this:

```
* * * * * cd /path/to/your/statu/root && php artisan schedule:run >> /dev/null 2>&1
```

Then, create a MonitorCallback:

```bash
$ php artisan statu:add-monitor-callback [MONITOR ID]
# If you have forgotten your monitor id, you may use `php artisan statu:list-monitors` to check it.
```

You will get output that looks something like this:

```
Callback for monitor voluptatem animi fuga was created.
The callback URL is: http://<BASE URL>/api/heartbeat?monitor=3&key=5wpzPvhggAXQAHBqAcQK2wRiOeleWNh5rlbkSh68Cy28Js0PzJh1C10SLx9z0Lti
```

Then, at the server, add a cron job that looks something like this: (change the url)

```
*/5 * * * * curl http://<BASE URL>/api/heartbeat?monitor=3&key=5wpzPvhggAXQAHBqAcQK2wRiOeleWNh5rlbkSh68Cy28Js0PzJh1C10SLx9z0Lti
```
