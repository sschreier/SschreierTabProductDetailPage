<?php
declare(strict_types=1);

/*
 * (c) Sebastian Schreier <info@sebastianschreier.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sschreier\TabProductDetailPage\Migration;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Migration\InheritanceUpdaterTrait;
use Shopware\Core\Framework\Migration\MigrationStep;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\CustomField\CustomFieldTypes;
use Sschreier\TabProductDetailPage\SschreierTabProductDetailPage;

final class Migration1693936500CustomFieldProductTabs extends MigrationStep
{
    use InheritanceUpdaterTrait;

    public const CUSTOM_FIELD_SET_TECHNICAL_NAME = 'sschreier_tabs_';

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

    public function updateDestructive(Connection $connection): void
    {
    }

    protected function createCustomFieldSet(Connection $connection, int $number): string
    {
        $customFieldSetId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldSetSql(),
            [
                'id' => $customFieldSetId,
                'name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME . $number,
                'config' => '{"label": {"de-DE": "Tab ' . $number .'", "en-GB": "tab ' . $number .'"}, "translated": true}',
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
                'name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME . 'tab' . $number . '_headline',
                'fieldType' => CustomFieldTypes::TEXT,
                'config' => '{"label": {"de-DE": "Überschrift", "en-GB": "headline"}, "placeholder": {"de-DE": "Überschrift des Tabs", "en-GB": "headline of the tab"}, "componentName": "sw-field", "customFieldType": "text", "customFieldPosition": 1, "type": "text"}',
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
            ],
        );

        $customFieldId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldSql(),
            [
                'id' => $customFieldId,
                'name' => self::CUSTOM_FIELD_SET_TECHNICAL_NAME . 'tab' . $number . '_content',
                'fieldType' => CustomFieldTypes::HTML,
                'config' => '{"label": {"de-DE": "Inhalt", "en-GB": "content"}, "componentName": "sw-text-editor", "customFieldType": "textEditor", "customFieldPosition": 2}',
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
            ],
        );
    }

    protected function createCustomFieldRelation(Connection $connection, $customFieldSetId): void
    {
        $customFieldRelationId = Uuid::randomBytes();

        $connection->executeStatement(
            self::getCustomFieldRelationSql(),
            [
                'id' => $customFieldRelationId,
                'set_id' => $customFieldSetId,
                'created_at' => self::getDateTimeValue(),
                'entity_name' => 'product'
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
                (:id, :name, :fieldType, :config, 1, :set_id, :created_at, NULL, 1);
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
        return (new \DateTime())->format(Defaults::STORAGE_DATE_TIME_FORMAT);
    }
}
