<?php

use yii\db\Migration;

/**
 * Class m180319_180002_tabla_rol
 */
class m180319_180002_tabla_rol extends Migration
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

        $this->createTable('{{%rol}}', [
            'rol_id' => $this->primaryKey(),
            'nombre' => $this->string(255),
            'descripcion' => $this->string(255)->notNull(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);
        $this->addForeignKey('rol_fk_usuario_creado', '{{%rol}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('rol_fk_usuario_actualizado', '{{%rol}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'rol_fk_usuario_creado',
            'rol'
        );

        $this->dropForeignKey(
            'rol_fk_usuario_actualizado',
            'rol'
        );

        $this->dropTable('{{%rol}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180319_184813_tabla_rol cannot be reverted.\n";

        return false;
    }
    */
}
