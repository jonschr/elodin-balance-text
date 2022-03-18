# Text Balancer

A fast text wrap balancer for multi-line headlines on the web.
Wraps texts more evenly across lines. Reduces uneven line lengths.

Rebalances texts on device orientation changes or when the window or element is resized.

Intended as a fallback for web browsers that don’t yet support the `text-wrap: balance`
CSS property. (No browsers support this property as of September 2021.)

Based on the [Text Balancer](https://github.com/nytimes/text-balancer/) module
by ©2016–2017 _New York Times Company_.
Differences between this implementation and the original are
[documented in this companion article](https://www.ctrl.blog/entry/text-wrap-balance.html).


## Usage


### Minimum

1. Apply a `balance-text` class to your headline elements.
2. Make sure headlines are wrapped in a parent element that specifies the desired max-width.
   (You can’t set this on the headline element itself.)
3. Load `text-balancer.js`.


### Recommended

See the `boilerplate.html` file.
It has some advantages like hiding the flash of unstyled content (FOUC) that may briefly show unbalanced text.
