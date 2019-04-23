# blubolt/head-tags
Library for building head tags with a focus on SEO.

A number of tag builders are provided:
* **CommonBuilder**  
  Common SEO tags (see https://moz.com/blog/seo-meta-tags for a primer)

* **OpenGraphBuilder**  
  [OpenGraph](http://ogp.me) used by the likes of Facebook, LinkedIn and Pinterest
  
* **TwitterBuilder**  
  [Twitter cards](https://dev.twitter.com/cards/markup)

* **ResourceBuilder**  
  [Resource hints](https://www.w3.org/TR/resource-hints), stylesheet and script tags
  
* **FacebookBuilder**  
  Facebook insights/scraper authorization

You can check the builder sources for a full list of all supported tags.

## Installation
You can install directly via Composer:
```bash
$ composer require "blubolt/head-tags":"^2.0"
```

## Basic usage
```php
$builder = new BuilderDelegate(
   new CommonBuilder(),
   new TwitterBuilder(),
   new OpenGraphBuilder()
);

$headerChunk = $builder
    ->add('title', 'your title')
    ->add('description', 'your description')
    ->add('language', 'your language')
    ->add('canonical', 'your canonical url')
    ->add('image', 'your image url')
    ->build();
```
As result you will have the following:
```html
<title>your title</title>
<meta name="description" content="your description"/>
<link rel="canonical" href="your canonical url"/>
<meta name="twitter:title" content="your title"/>
<meta name="twitter:description" content="your description"/>
<meta name="twitter:image" content="your image url"/>
<meta property="og:title" content="your title"/>
<meta property="og:description" content="your description"/>
<meta property="og:locale" content="your language"/>
<meta property="og:url" content="your canonical url"/>
<meta property="og:image" content="your image url"/>
```

## Extending
To add another builder you must implement `BuilderInterface`, more often than not by simply
extending `AbstractBuilder`.
