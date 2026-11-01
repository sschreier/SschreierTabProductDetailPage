<?php
declare(strict_types=1);

/*
 * (c) Sebastian Schreier <info@web-solutions-dresden.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sschreier\TabProductDetailPage;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class SschreierTabProductDetailPage extends Plugin
{
    const CUSTOM_FIELD_SET_TECHNICAL_NAME = 'sschreier_tabs_';
    const NUMBER_TABS = 5;

    public function uninstall(UninstallContext $uninstallContext): void
    {
        if ($uninstallContext->keepUserData()) {
            parent::uninstall($uninstallContext);

            return;
        }

        $this->removeCustomField($uninstallContext->getContext());

        parent::uninstall($uninstallContext);
    }

    private function removeCustomField(Context $context): void
    {
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        for ($i = 1; $i <= self::NUMBER_TABS; ++$i) {
            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('name', self::CUSTOM_FIELD_SET_TECHNICAL_NAME . $i));

            $result = $customFieldSetRepository->searchIds($criteria, $context);

            if ($result->getTotal() > 0) {
                $data = $result->getDataOfId($result->firstId());
                $customFieldSetRepository->delete([$data], $context);
            }
        }
    }
}
