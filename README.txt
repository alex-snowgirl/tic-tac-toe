From previous try:
DONE - No sanitization/validation of user input that can lead to PHP fatal errors.
DONE - From the source code, we can see that the game should be using a minimax algorithm but when playing the IA moves looks random.
+ The code style is consistent (PSR/2).
+ The code is easy to understand and the abstraction is really good.
DONE - It'd have been appreciated to have some unit tests.
DONE - The commits would have gained to be more atomic.
DONE - It's still possible to play after someone won the game, which made it possible to win after having loose.

To install:

1) cd <project_dir>
2) composer install
3) cd pub/
4) php -S localhost:8000
5) in browser - http://localhost:8000
6) to run tests: php vendor/bin/phpunit tests

PS: Very simple implementation (minimum to work properly)
If something - ask
Thanks for this awesome trip in TTT world