# Simple Mockups

Ultra simple html based app screen prototyping tool.

## Main features

* each mockup screen is one single file (allows easy organization and quick visual overview...)
* navigation between screens is as easy as `href="#screen-id"`
* trivial PHP server side rendering (single file, ~20 lines of code)
* table of contents and breadcrumbs automatically generated
* js helper fn for child screens navigation
* everything fully and easily hackable (js, html, css, php)
* intended mainly as a navigation/structure prototyping tool, not as a visual one
(although each screen is just a html `<section>` so there are no limits)

## Demo &amp; Source

http://marian.meres.sk/simple-mockups-demo/  
https://github.com/marianmeres/simple-mockups

## Notes

Screens in the [TOC](http://marian.meres.sk/simple-mockups-demo/#_toc) are sorted 
alphabetically by their filenames. If you need a specific order prefix the 
filename with digits just as I did in the [demo](https://github.com/marianmeres/simple-mockups/tree/master/screens/index).

Screen id is generated from the file path where directory separators are 
replaced with underscores, so usage of underscores in file names will most likely
cause the breadcrumbs and TOC to not work correctly.

