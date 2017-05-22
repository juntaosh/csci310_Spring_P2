# Word Cloud generator v2.0

This is the word cloud generator version two.

## Specific details of the design

It gathers informations from IEEE and ACM to generate the results base on the word/ words
that is placed in the input fields. After successfully gather information from the web, this generator will automatically sort based on thier frequency in all papers that is specified by the user. Clicking on the results of one specific words will display more information. Clicking on more specific places will give user more specificed results.


### Specific features:

```
*Initial page that allows one to input search criteria comprised of a researcher’s last name
*When a search is submitted, it should create word cloud of the top X number of papers in the ACM and IEEE digital library that match the provided criteria
*Clicking on a word in the cloud should return a list of papers that mention that word
*For each paper, provide links to download it from the digital library
*For each paper, provide links to access its bibtex
*Show a status bar for current progress in generating the word cloud
*For each paper, clicking on an author in its author list will do a new search based on that
author
*For each paper, clicking on a paper’s conference name will list other papers from that conference
*For each paper, clicking on a paper’s title will allow the user to read the abstract with the word(s) highlighted
*Export lists of papers as PDFs and plain text
*Access previously entered searches
*For the paper list, allow users to select a subset to generate a new word cloud from
*Allow for the downloading of an image of the generated word cloud
*Initial page that allows one to input search criteria comprised of keyword phrase
*For each paper, clicking on the paper's title will give the user access for download a PDF version of the paper with the word highlighted in the PDF
```

## Tests?

Both [Black Box testing](https://github.com/juntaosh/csci310_Spring_P2/tree/master/Testing) and[White box testing] can be found in the main directory. Black box testing uses behat and selenium3 driver. White box testing uses PHP unit. (make sure you have composer and needed software installed in the Ubuntu).

## Authors:
* [Yawen Cao](https://github.com/yawencao)
* [Mengyao He](https://github.com/mengyaoh)
* [Juntao Shen](https://github.com/juntaosh)
* [Qingzhou Tang](https://github.com/qingzhot)
* [Nicholas Thompson](https://github.com/Nmthomps)
* [Lifan Zhao](https://github.com/humberthumbert)

## Comments and more
All comments are welcomed but I don't think we will be updating it in a while. Others suffering from projects or testing can use this as a reference to guide you to a more comfortable coding environment. This is a CSCI310 project directory from [USC](http://www.usc.edu) Spring 2017 by Professor Halfond.
