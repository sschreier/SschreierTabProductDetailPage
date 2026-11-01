<?php
declare(strict_types=1);

/*
 * (c) Sebastian Schreier <info@web-solutions-dresden.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sschreier\TabProductDetailPage\Migration;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\CustomField\CustomFieldTypes;
use Sschreier\TabProductDetailPage\SschreierTabProductDetailPage;

final class Migration1693936500CustomFieldProductTabs extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1693936500;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function update(Connection $connection): void
    {
        for ($i = 1; $i <= SschreierTabProductDetailPage::NUMBER_TABS; ++$i) {
            $customFieldSetId = $this->createCustomFieldSet($connection, $i);

            $this->createCustomField($connection, $customFieldSetId, $i);

            $this->createCustomFieldRelation($connection, $customFieldSetId);
        }
    }

    protected function createCustomFieldSet(Connection $connection, int $number): string
    {
        $customFieldSetId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldSetSql(),
            [
                'id' => $customFieldSetId,
                'name' => SschreierTabProductDetailPage::CUSTOM_FIELD_SET_TECHNICAL_NAME . $number,
                'config' => json_encode([
                    'label' => [
                        'de-DE' => 'Tab ' . $number,
                        'en-GB' => 'tab ' . $number,
                    ],
                    'translated' => true,
                ], JSON_THROW_ON_ERROR),
                'position' => $number,
                'created_at' => self::getDateTimeValue(),
            ]
        );

        return $customFieldSetId;
    }

    protected function createCustomField(Connection $connection, string $customFieldSetId, int $number): void
    {
        $customFieldId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldSql(),
            [
                'id' => $customFieldId,
                'name' => SschreierTabProductDetailPage::CUSTOM_FIELD_SET_TECHNICAL_NAME . 'tab' . $number . '_headline',
                'fieldType' => CustomFieldTypes::TEXT,
                'config' => json_encode([
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
                ], JSON_THROW_ON_ERROR),
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
            ],
        );

        $customFieldId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldSql(),
            [
                'id' => $customFieldId,
                'name' => SschreierTabProductDetailPage::CUSTOM_FIELD_SET_TECHNICAL_NAME . 'tab' . $number . '_content',
                'fieldType' => CustomFieldTypes::HTML,
                'config' => json_encode([
                    'label' => [
                        'de-DE' => 'Inhalt',
                        'en-GB' => 'content',
                    ],
                    'componentName' => 'sw-text-editor',
                    'customFieldType' => 'textEditor',
                    'customFieldPosition' => 2,
                ], JSON_THROW_ON_ERROR),
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
            ],
        );
    }

    protected function createCustomFieldRelation(Connection $connection, string $customFieldSetId): void
    {
        $customFieldRelationId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldRelationSql(),
            [
                'id' => $customFieldRelationId,
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
                'entity_name' => ProductDefinition::ENTITY_NAME,
            ],
        );
    }

    protected static function getCustomFieldSetSql(): string
    {
        return <<<SQL
            INSERT INTO `custom_field_set` (id, name, config, active, app_id, position, global, created_at, updated_at) VALUES
            (:id, :name, :config, 1, NULL, :position, 0, :created_at, NULL);
            SQL;
    }

    public static function getCustomFieldSql(): string
    {
        return <<<SQL
                INSERT INTO `custom_field` (`id`, `name`, `type`, `config`, `active`, `set_id`, `created_at`, `updated_at`, `allow_customer_write`) VALUES
                (:id, :name, :fieldType, :config, 1, :set_id, :created_at, NULL, 0);
            SQL;
    }

    public static function getCustomFieldRelationSql(): string
    {
        return <<<SQL
                INSERT INTO `custom_field_set_relation` (`id`, `set_id`, `entity_name`, `created_at`, `updated_at`) VALUES
                (:id, :set_id, :entity_name, :created_at, NULL);
            SQL;
    }

    protected static function getDateTimeValue(): string
    {
        return (new DateTimeImmutable())->format(Defaults::STORAGE_DATE_TIME_FORMAT);
    }
}
