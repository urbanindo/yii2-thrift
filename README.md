# yii2-thrift
Thrift extension for Yii2

[![Latest Stable Version](https://poser.pugx.org/urbanindo/yii2-thrift/v/stable.svg)](https://packagist.org/packages/urbanindo/yii2-thrift)
[![Total Downloads](https://poser.pugx.org/urbanindo/yii2-thrift/downloads.svg)](https://packagist.org/packages/urbanindo/yii2-thrift)
[![Latest Unstable Version](https://poser.pugx.org/urbanindo/yii2-thrift/v/unstable.svg)](https://packagist.org/packages/urbanindo/yii2-thrift)
[![Build Status](https://travis-ci.org/urbanindo/yii2-thrift.svg)](https://travis-ci.org/urbanindo/yii2-thrift)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist urbanindo/yii2-thrift "*"
```

or add

```
"urbanindo/yii2-thrift": "*"
```


# Minimum Requirement

- Thrift version 0.9.2.
  To install thrift, check http://thrift.apache.org/download
- Yii 2.0.0

# Usage

Put the thrift file into some directory `thrift` in the root is preferable.

Generate the thrift file using command below.

```
thrift --gen php:server,oop path/to/the/thrift/file
```

In the `index.php` instead of using the default `yii\web\Application` use 
`UrbanIndo\Yii2\Thrift\Application`.

In the component configuration add the `thrift` configuration.

```php
return [
    'component' => [
        'thrift' => [
            'serviceMap' => [
                '' => 'service'
            ]
        ]
    ]
]
```

Create a service in the `services` directory, similar to `controllers`. 
This should implement both the Interface from generated Thrift file **and**
`UrbanIndo\Yii2\Thrift\Service` interface.

```php
class HelloService implements \myservice\HelloServiceIf, \UrbanIndo\Yii2\Thrift\Service {

    public function getProcessorClass {
        return 'myservice\HelloServiceProcessor';
    }
}
```