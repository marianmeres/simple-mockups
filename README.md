# Simple Mockups

Simple html based app screen prototyping tool.

## Main features

* each mockup screen is one single file (quick visual overview...)
* easy navigation between screens via `href="#screen-id"`
* screen hierarchy automatically generated from filesystem
* trivial PHP server side rendering (single file, &plusmn;20 lines of code)
* table of contents and breadcrumbs automatically generated
* everything fully and easily hackable (js, html, css, php)
* intended mainly as a navigation/structure prototyping tool not a visual one
(although plaing with html is not limited)

## Demo &amp; Source

http://marian.meres.sk/simple-mockups-demo/  
https://github.com/marianmeres/simple-mockups

## Limitations

Screen id is genereated from the filesystem path of the screen file where 
directory separators are replaced with underscores, so usage of underscores 
in file names will cause the breadcrumbs and TOC to not work correctly.

