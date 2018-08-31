<?php

use yii\db\Migration;

/**
 * Class m180319_180004_tabla_proceso
 */
class m180319_180009_tabla_rol_proceso_accion extends Migration
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

        $this->createTable('{{%rol_proceso_accion}}', [
            'rol_proceso_accion_id' => $this->primaryKey(),
            'rol_proceso_id' => $this->integer(11)->notNull(),
            'accion' => $this->string()->notNull(),


            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('rol_proceso_accion_fk_rol_proceso', '{{%rol_proceso_accion}}', 'rol_proceso_id', '{{%rol_proceso}}', 'rol_proceso_id');

        $this->addForeignKey('rol_proceso_accion_fk_usuario_creado', '{{%rol_proceso_accion}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('rol_proceso_accion_fk_usuario_actualizado', '{{%rol_proceso_accion}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'rol_proceso_accion_fk_rol_proceso',
            'rol_proceso_accion'
        );

        $this->dropForeignKey(
            'rol_proceso_accion_fk_usuario_creado',
            'rol_proceso_accion'
        );

        $this->dropForeignKey(
            'rol_proceso_accion_fk_usuario_actualizado',
            'rol_proceso_accion'
        );

        $this->dropTable('{{%rol_proceso_accion}}');
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
