<?php

use yii\db\Migration;

/**
 * Class m180319_185700_tabla_rol_proceso
 */
class m180319_180005_tabla_rol_proceso extends Migration
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

        $this->createTable('{{%rol_proceso}}', [
            'rol_proceso_id' => $this->primaryKey(),
            'rol_id' => $this->integer(11)->notNull(),
            'proceso_id' => $this->integer(11)->notNull(),
            'permiso' => $this->string(100),
            'descripcion' => $this->string(100)->notNull(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
            'mostrar_en_arbol' => $this->integer(1)->defaultValue(1),///  1 mostrar, otherwise ocultar en el menu
        ], $tableOptions);
        $this->addForeignKey('rol_proceso_fk_usuario_creado', '{{%rol_proceso}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('rol_proceso_fk_usuario_actualizado', '{{%rol_proceso}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('rol_proceso_fk_proceso', '{{%rol_proceso}}', 'proceso_id', '{{%proceso}}', 'proceso_id');
        $this->addForeignKey('rol_proceso_fk_rol', '{{%rol_proceso}}', 'rol_id', '{{%rol}}', 'rol_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'rol_proceso_fk_usuario_creado',
            'rol_proceso'
        );

        $this->dropForeignKey(
            'rol_proceso_fk_usuario_actualizado',
            'rol_proceso'
        );

        $this->dropForeignKey(
            'rol_proceso_fk_proceso',
            'rol_proceso'
        );

        $this->dropForeignKey(
            'rol_proceso_fk_rol',
            'rol_proceso'
        );
        
        $this->dropTable('{{%rol_proceso}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180319_185700_tabla_rol_proceso cannot be reverted.\n";

        return false;
    }
    */
}
