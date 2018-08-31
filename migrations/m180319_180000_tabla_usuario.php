<?php

use yii\db\Migration;

/**
 * Class m180319_180000_tabla_usuario
 */
class m180319_180000_tabla_usuario extends Migration
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

        $this->createTable('{{%usuario}}', [
            'usuario_id' => $this->primaryKey(),
            'alias' => $this->string(255)->notNull(),/// es el nombre con el que te has de logear
            /*
            'nombre' => $this->string(255)->notNull(),
            'apellido_paterno' => $this->string(255)->notNull(),
            'apellido_materno' => $this->string(255)->notNull(),
            // */
            'clave_autenticacion' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'token_de_acceso' => $this->string(100),
            'pregunta_secreta_1' => $this->string(255),
            'pregunta_secreta_2' => $this->string(255),
            'pregunta_secreta_3' => $this->string(255),
            'respuesta_secreta_1' => $this->string(255),
            'respuesta_secreta_2' => $this->string(255),
            'respuesta_secreta_3' => $this->string(255),
            'persona_id' => $this->integer(11),
        ], $tableOptions);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%usuario}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180319_184840_tabla_usuarios cannot be reverted.\n";

        return false;
    }
    */
}
