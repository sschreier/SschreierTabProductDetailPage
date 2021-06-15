# A extension for a tab for the product detail page for Shopware 6

A extension for a _tab for the product detail page_, which can be _displayed before and after the reviews tab_. The _content_ of the tab _comes_ either _from the rich text editor at the product_ or _from a snippet_. The tab is also displayed when assigning a product page layout. When you increase the value from the constant _NUMBER_TABS_ in the file _SschreierTabProductDetailPage.php_ in the _src_-directory before the installation, you can add so much tabs as you like.

## Possible Configurations 
 - select, if the tab should be shown before the rating tab
 - select, if the tab should be filled via a snippet
 - set the mumber of characters from which the preview text in smaller resolutions should be truncated

## Available snippets
 - tabHeadlineFillViaSnippet
 - tabHeadline
 - tabContentPreviewMore
 - tabContentPreviewText
 - tabContentFillViaSnippet
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

### extension configuration

![extension configuration](https://www.sebastianschreier.de/plugins/SschreierTabProductDetailPage/SschreierTabProductDetailPage-Image3.jpg)

### custom tab headline and content in shopware administration

![custom tab headline and content in shopware administration](https://www.sebastianschreier.de/plugins/SschreierTabProductDetailPage/SschreierTabProductDetailPage-Image4.jpg)
