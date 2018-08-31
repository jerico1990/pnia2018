<?php

use yii\db\Migration;

/**
 * Class m180319_180004_tabla_proceso
 */
class m180319_180004_tabla_proceso extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%proceso}}', [
            'proceso_id' => $this->primaryKey(),
            'modulo_id' => $this->integer(11)->notNull(),
            'descripcion' => $this->string(255)->notNull(),
            'url_accion' => $this->string(255)->notNull(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);
        $this->addForeignKey('proceso_fk_usuario_creado', '{{%proceso}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('proceso_fk_usuario_actualizado', '{{%proceso}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('proceso_fk_modulo', '{{%proceso}}', 'modulo_id', '{{%modulo}}', 'modulo_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'proceso_fk_usuario_creado',
            'proceso'
        );

        $this->dropForeignKey(
            'proceso_fk_usuario_actualizado',
            'proceso'
        );

        $this->dropForeignKey(
            'proceso_fk_modulo',
            'proceso'
        );

        $this->dropTable('{{%proceso}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180319_184801_tabla_proceso cannot be reverted.\n";

        return false;
    }
    */
}
