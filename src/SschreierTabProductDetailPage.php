<?php
declare(strict_types=1);

/*
 * (c) Sebastian Schreier <info@sebastianschreier.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sschreier\TabProductDetailPage;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class SschreierTabProductDetailPage extends Plugin
{
    const CUSTOM_FIELD_SET_TECHNICAL_NAME = 'sschreier_tabs_';
    const NUMBER_TABS = 5;

    public function install(InstallContext $installContext): void
    {
        parent::install($installContext);
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        if ($uninstallContext->keepUserData()) {
            parent::uninstall($uninstallContext);

            return;
        }

        $this->removeCustomField($uninstallContext->getContext());

        parent::uninstall($uninstallContext);
    }

    private function removeCustomField($uninstallContext): void
    {
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        for ($i = 1; $i <= SschreierTabProductDetailPage::NUMBER_TABS; ++$i) {
            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('name', self::CUSTOM_FIELD_SET_TECHNICAL_NAME . $i));

            $result = $customFieldSetRepository->searchIds($criteria, $uninstallContext);

            if ($result->getTotal() > 0) {
                $data = $result->getDataOfId($result->firstId());
                $customFieldSetRepository->delete([$data], $uninstallContext);
            }
        }
    }
}
