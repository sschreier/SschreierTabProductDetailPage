<?php
declare(strict_types=1);

namespace Sschreier\TabProductDetailPage;

    use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
    use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
    use Shopware\Core\Framework\Plugin;
    use Shopware\Core\Framework\Plugin\Context\ActivateContext;
    use Shopware\Core\Framework\Plugin\Context\DeactivateContext;
    use Shopware\Core\Framework\Plugin\Context\InstallContext;
    use Shopware\Core\Framework\Plugin\Context\UninstallContext;
    use Shopware\Core\Framework\Plugin\Context\UpdateContext;
    use Shopware\Core\System\CustomField\CustomFieldTypes;

    class SschreierTabProductDetailPage extends Plugin
    {
        const CUSTOM_FIELD_SET_TECHNICAL_NAME = 'sschreier_tabs_';
        const NUMBER_TABS = 5;

        public function install(InstallContext $installContext): void
        {
            $customFieldSetRepository = $this->container->get('custom_field_set.repository');

            for ($i = 1; $i <= SschreierTabProductDetailPage::NUMBER_TABS; ++$i) {
                $criteria = new Criteria();

                $criteria->addFilter(new EqualsFilter('name', self::CUSTOM_FIELD_SET_TECHNICAL_NAME . $i));

                $result = $customFieldSetRepository->searchIds($criteria, $installContext->getContext());

                if (!($result->getTotal() > 0)) {
                    $customFieldSetRepository->create([[
                        'name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME . $i,
                        'config' => [
                            'label' => [
                                'de-DE' => 'Tab ' . $i,
                                'en-GB' => 'tab ' . $i,
                            ],
                        ],
                        'position' => $i,
                        'customFields' => [
                            [
                                'name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME . 'tab' . $i . '_headline',
                                'type' => CustomFieldTypes::TEXT,
                                'config' => [
                                    'label' => [
                                        'de-DE' => 'Überschrift',
                                        'en-GB' => 'headline',
                                    ],
                                    'placeholder' => [
                                        'de-DE' => 'Überschrift des Tabs',
                                        'en-GB' => 'headline of the tab',
                                    ],
                                    'componentName' => 'sw-field',
                                    'customFieldType' => 'text',
                                    'customFieldPosition' => 1,
                                    'type' => 'text',
                                ],
                            ],
                            [
                                'name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME . 'tab' . $i . '_content',
                                'type' => CustomFieldTypes::HTML,
                                'config' => [
                                    'label' => [
                                        'de-DE' => 'Inhalt',
                                        'en-GB' => 'content'
                                    ],
                                    'componentName' => 'sw-text-editor',
                                    'customFieldType' => 'textEditor',
                                    'customFieldPosition' => 2,
                                ]
                            ],
                        ],
                        'relations' => [
                            ['entityName' => 'product'],
                        ],
                    ]], $installContext->getContext());
                }
            }

            parent::install($installContext);
        }

        public function postInstall(InstallContext $installContext): void
        {
            parent::postInstall($installContext);
        }

        public function update(UpdateContext $updateContext): void
        {
        }

        public function postUpdate(UpdateContext $updateContext): void
        {
        }

        public function activate(ActivateContext $activateContext): void
        {
            parent::activate($activateContext);
        }

        public function deactivate(DeactivateContext $deactivateContext): void
        {
            parent::deactivate($deactivateContext);
        }

        public function uninstall(UninstallContext $uninstallContext): void
        {
            if ($uninstallContext->keepUserData()) {
                parent::uninstall($uninstallContext);

                return;
            }

            $customFieldSetRepository = $this->container->get('custom_field_set.repository');

            for ($i = 1; $i <= SschreierTabProductDetailPage::NUMBER_TABS; ++$i) {
                $criteria = new Criteria();
                $criteria->addFilter(new EqualsFilter('name', self::CUSTOM_FIELD_SET_TECHNICAL_NAME . $i));

                $result = $customFieldSetRepository->searchIds($criteria, $uninstallContext->getContext());

                if ($result->getTotal() > 0 && !$uninstallContext->keepUserData()) {
                    $data = $result->getDataOfId($result->firstId());
                    $customFieldSetRepository->delete([$data], $uninstallContext->getContext());
                }
            }

            parent::uninstall($uninstallContext);
        }
    }
