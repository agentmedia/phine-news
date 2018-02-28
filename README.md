= About the News Bundle =

Developed by the Phine core team, the news bundle is designed to add basic news
and blogging functionality to the cms.


== Version History ==

=== 1.0.0 ===

First version including the following elements.

* news archive
* news category
* news article
* content element article list
* content element news pager
* content element article (detail view)

The news articles have headline, teaser and text.

The news are organized in archives. Each archive contains categories
and holds common display settings. Each news article has exactly one specific
category.

Categories and archives can be assigned a unique page to display a list on it.
The page for a single article item can be assigned on the article list element.
Note that you can use the parameter "article" in the article page url, e.g. like so  
news/{article}.html

== Version History ==
=== 1.0.0  ===
 - First working version

=== 1.0.1, 1.0.2, 1.0.3, 1.0.4, 1.0.5 ===
  - Added "ReadMore" wording in article list
  - Added multiple missing translations
  - Replaced the wrapper tag for article teaser and texts from <p> to <div>
    in default frontend templates to avoid invalid HTML caused by surrounding <p> from backend rich text editor
  - Added already planned meta title adjustment by article title and teaser