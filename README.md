
# matrix
* Matrix alphabet rain in console.

# Install
    $ export PATH=$PATH:$HOME/.composer/vendor/bin
    $ composer global require bency/php-matrix-rain
    $ matrix

* We provide three different colors:
![image](https://raw.githubusercontent.com/bency/matrix/master/images/matrix-preview-green.png)
![image](https://raw.githubusercontent.com/bency/matrix/master/images/matrix-preview-blue.png)
![image](https://raw.githubusercontent.com/bency/matrix/master/images/matrix-preview-gray.png)

* We provide marquees

       $ matrix --marquee --wording "MATRIX"
![image](https://raw.githubusercontent.com/bency/matrix/master/images/marquee.png)

* Also can show timer on marquee

        $ matrix --timer --timer-format "Y-m-d"
![image](https://raw.githubusercontent.com/bency/matrix/master/images/timer.png)

## keyboard short cut

- c change raining color
- a increase the length of rain
- s decrease the length of rain

### Raining speed
- \- slow down
- = speed up
- q quit

### Raining density
- 1 increase life time for head
- 2 decrease life time for head
- x increase life time for tail
- z decrease life time for tail
