# Spress Remote JSON

Spress plugin to add remote_json() function to Twig templates

Perfect for getting data from APIs

## Installation

`composer require knorthfield/spress-remote-json`

## How to Use

In Twig template, set response to variable, use variable in template.

```
{% set data = remote_json('https://api.example.com/endpoint/') %}
{{ data.item }}
```
