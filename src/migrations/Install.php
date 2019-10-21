<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace robottens\dailystatistics\migrations;

use Craft;
use craft\db\Migration;

/**
 * Entry Count Install Migration
 */
class Install extends Migration
{
    // Public Methods
    // =========================================================================

    /**
     * @return boolean
     */
    public function safeUp(): bool
    {
        if (!$this->db->tableExists('{{%entrycount}}')) {
            $this->createTable('{{%entrycount}}', [
                'date' => $this->date()->notNull(),
                'entryId' => $this->integer()->notNull(),
                'count' => $this->integer()->defaultValue(0)->notNull(),
                'uniqueCount' => $this->integer()->defaultValue(0)->notNull(),
                'qualityCount' => $this->integer()->defaultValue(0)->notNull(),
                'qualityUniqueCount' => $this->integer()->defaultValue(0)->notNull(),
            ]);

            $this->createIndex(null, '{{%entrycount}}', 'date', false);
            $this->createIndex(null, '{{%entrycount}}', 'entryId', false);
            $this->createIndex(null, '{{%entrycount}}', ['date', 'entryId'], true);

            $this->addForeignKey(null, '{{%entrycount}}', 'entryId', '{{%elements}}', 'id', 'CASCADE');

            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
        }

        return true;
    }

    /**
     * @return boolean
     * @throws \Throwable
     */
    public function safeDown(): bool
    {
        $this->dropTableIfExists('{{%entrycount}}');

        return true;
    }
}
