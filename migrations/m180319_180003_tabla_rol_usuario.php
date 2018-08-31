<?php

use yii\db\Migration;

/**
 * Class m180319_180003_tabla_rol_usuario
 */
class m180319_180003_tabla_rol_usuario extends Migration
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

        $this->createTable('{{%rol_usuario}}', [
            'rol_usuario_id' => $this->primaryKey(),
            'usuario_id' => $this->integer(11)->notNull(),
            'rol_id' => $this->integer(11)->notNull(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);
        $this->addForeignKey('rol_usuario_fk_usuario_creado', '{{%rol_usuario}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('rol_usuario_fk_usuario_actualizado', '{{%rol_usuario}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('rol_usuario_fk_usuario', '{{%rol_usuario}}', 'usuario_id', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('rol_usuario_fk_rol', '{{%rol_usuario}}', 'rol_id', '{{%rol}}', 'rol_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'rol_usuario_fk_usuario_creado',
            'rol_usuario'
        );
     
        $this->dropForeignKey(
            'rol_usuario_fk_usuario_actualizado',
            'rol_usuario'
        );

        $this->dropForeignKey(
            'rol_usuario_fk_usuario',
            'rol_usuario'
        );
     
        $this->dropForeignKey(
            'rol_usuario_fk_rol',
            'rol_usuario'
        );
        
        $this->dropTable('{{%rol_usuario}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180319_185633_tabla_roles_usuario cannot be reverted.\n";

        return false;
    }
    */
}
