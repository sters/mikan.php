# mikan.php

[![CircleCI](https://circleci.com/gh/sters/mikan.php.svg?style=svg)](https://circleci.com/gh/sters/mikan.php)
[![Packagist](https://img.shields.io/packagist/v/sters/mikan.php.svg)](https://packagist.org/packages/sters/mikan.php)

Resolve method of Japanese line break problem.

Transform from:
[Mikan.js - 機械学習を用いていない日本語改行問題へのソリューション](https://github.com/trkbt10/mikan.js)



# Usage

```
$mikan = new Mikan();
$result = $mikan->split('常に最新、最高のモバイル。Androidを開発した同じチームから。');

var_dump($result);
----
array(8) {
  [0]=>
  string(6) "常に"
  [1]=>
  string(9) "最新、"
  [2]=>
  string(9) "最高の"
  [3]=>
  string(15) "モバイル。"
  [4]=>
  string(10) "Androidを"
  [5]=>
  string(12) "開発した"
  [6]=>
  string(6) "同じ"
  [7]=>
  string(18) "チームから。"
}
```

This library will only splitting text, you need to make presentation logic yourself.
How about css styling, see transform from codes.  
[Mikan.js - 機械学習を用いていない日本語改行問題へのソリューション](https://github.com/trkbt10/mikan.js)




