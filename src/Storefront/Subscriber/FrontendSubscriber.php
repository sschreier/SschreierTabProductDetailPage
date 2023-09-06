<?php
declare(strict_types=1);

namespace Sschreier\TabProductDetailPage\Storefront\Subscriber;

use Shopware\Core\Content\Product\SalesChannel\SalesChannelProductEntity;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Sschreier\TabProductDetailPage\SschreierTabProductDetailPage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FrontendSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageLoadedEvent::class => 'onProductPageLoaded',
        ];
    }

    /**
     * provide the number of tabs on the product detail page
     */
    public function onProductPageLoaded(ProductPageLoadedEvent $event): SalesChannelProductEntity
    {
        $product = $event->getPage()->getProduct();

        $numberTabs['value'] = SschreierTabProductDetailPage::NUMBER_TABS;
        $numberTabsValue = $this->createArrayEntity($numberTabs);

        $product->addExtension('numberTabsValue', $numberTabsValue);

        return $product;
    }

    /**
     * create an ArrayEntity with the given data
     */
    private function createArrayEntity($extensionData): ArrayEntity
    {
        return new ArrayEntity($extensionData);
    }
}
