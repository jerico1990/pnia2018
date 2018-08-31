<?php

use yii\db\Migration;

class m180521_000008_create_proyecto extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%proyecto}}', [//contrato_carta_fianza
            'proyecto_id' => $this->primaryKey(),
            'nombre' => $this->string(),
            
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->addForeignKey('proyecto_fk_usuario_creado', '{{%proyecto}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('proyecto_fk_usuario_actualizado', '{{%proyecto}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'proyecto_fk_usuario_creado',
            'proyecto'
        );

        $this->dropForeignKey(
            'proyecto_fk_usuario_actualizado',
            'proyecto'
        );
        
        $this->dropTable('{{%proyecto}}');
    }
}