<?php

use yii\db\Migration;

/**
 * Class m180319_180001_tabla_modulo
 */
class m180319_180001_tabla_modulo extends Migration
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

        $this->createTable('{{%modulo}}', [
            'modulo_id' =>$this->primaryKey(),
            'nombre' => $this->string(100)->notNull(),
            'descripcion' => $this->string(255)->notNull(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);
        $this->addForeignKey('modulo_fk_usuario_creado', '{{%modulo}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('modulo_fk_usuario_actualizado', '{{%modulo}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'modulo_fk_usuario_creado',
            'modulo'
        );

        $this->dropForeignKey(
            'modulo_fk_usuario_actualizado',
            'modulo'
        );
        
        $this->dropTable('{{%modulo}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180319_184755_tabla_modulo cannot be reverted.\n";

        return false;
    }
    */
}
