# A extension for tabs for the product detail page for Shopware 6

A extension for _tabs for the product detail page_, which can be _displayed before or after the reviews tab_. The _content_ of the tabs _comes_ either _from the rich text editor at the product_ or _from a snippet_. The tabs are also displayed when assigning a product page layout. When you increase the value from the constant _NUMBER_TABS_ in the file _SschreierTabProductDetailPage.php_ in the _src_-directory before the installation, you can add so much tabs as you like.

## Possible Configurations 
 - select, if the tabs should be shown before the rating tab
 - set the number of characters from which the preview text in smaller resolutions should be truncated
 - select, if tab 1 should be filled via a snippet
 - set the headline of tab 1 via snippet
 - set the content of tab 1 via snippet
 - select, if tab 2 should be filled via a snippet
 - set the headline of tab 2 via snippet
 - set the content of tab 2 via snippet
 - select, if tab 3 should be filled via a snippet
 - set the headline of tab 3 via snippet
 - set the content of tab 3 via snippet
 - select, if tab 4 should be filled via a snippet
 - set the headline of tab 4 via snippet
 - set the content of tab 4 via snippet
 - select, if tab 5 should be filled via a snippet
 - set the headline of tab 5 via snippet
 - set the content of tab 5 via snippet

## Available snippets
 - tabHeadlineFillViaSnippet
 - tab2HeadlineFillViaSnippet
 - tab3HeadlineFillViaSnippet
 - tab4HeadlineFillViaSnippet
 - tab5HeadlineFillViaSnippet
 - tabHeadline
 - tabContentPreviewMore
 - tabContentPreviewText
 - tabContentFillViaSnippet
 - tab2ContentFillViaSnippet
 - tab3ContentFillViaSnippet
 - tab4ContentFillViaSnippet
 - tab5ContentFillViaSnippet
 - tabContent

## How to install the extension
### via console (recommended)
1. Download the latest _SschreierTabProductDetailPage-master.zip_.
2. Unzip the zip file and rename the folder to _SschreierTabProductDetailPage_. 
3. Move the folder to the project folder _custom/plugins/_ .
4. Connect to the console via ssh:

```
bin/console plugin:refresh
bin/console plugin:install --activate SschreierTabProductDetailPage
```

### via composer
1. Add the repository URL to the composer.json of the project
```
"repositories": [
    ...,
    {
        "type": "vcs",
        "url": "https://github.com/sschreier/SschreierTabProductDetailPage"
    }
],
```

2. Connect to the console via ssh and install the plugin source code via the command
```
composer require sschreier/sschreiertabproductdetailpage
bin/console plugin:refresh
bin/console plugin:install --activate SschreierTabProductDetailPage
```

### via zip upload
1. Download the latest _SschreierTabProductDetailPage-master.zip_.
2. Unzip the zip file and rename the folder to _SschreierTabProductDetailPage_.
3. Zip the folder to _SschreierTabProductDetailPage.zip_.
4. Upload the zip in the Shopware Administration.
5. Install & Activate the extension.

#### extension update (zip)
1. Download the latest _SschreierTabProductDetailPage-master.zip_.
2. Unzip the zip file and rename the folder to _SschreierTabProductDetailPage_.
3. Zip the folder to _SschreierTabProductDetailPage.zip_.
4. Upload the zip in the Shopware Administration.
5. Update the extension.

## Images

### default description tab

![default description tab](https://www.sebastianschreier.de/plugins/SschreierTabProductDetailPage/SschreierTabProductDetailPage-Image1.jpg)

### custom tab headline and content via product custom field

![custom tab headline and content via product custom field](https://www.sebastianschreier.de/plugins/SschreierTabProductDetailPage/SschreierTabProductDetailPage-Image2.jpg)

### extension configuration part 1

![extension configuration](https://www.sebastianschreier.de/plugins/SschreierTabProductDetailPage/SschreierTabProductDetailPage-Image3.jpg)

### extension configuration part 2

![extension configuration](https://www.sebastianschreier.de/plugins/SschreierTabProductDetailPage/SschreierTabProductDetailPage-Image5.jpg)

### custom tab headline and content in shopware administration

![custom tab headline and content in shopware administration](https://www.sebastianschreier.de/plugins/SschreierTabProductDetailPage/SschreierTabProductDetailPage-Image4.jpg)
