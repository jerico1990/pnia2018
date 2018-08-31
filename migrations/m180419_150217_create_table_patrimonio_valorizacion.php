<?php

use yii\db\Migration;

class m180419_150217_create_table_patrimonio_valorizacion extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%patrimonio_valorizacion}}', [
            'patrimonio_valorizacion_id' => $this->primaryKey(),
            'patrimonio_item_id' => $this->integer(11),
            'metacodigo_id' => $this->integer(11),
            'valor' => $this->double(),
            'fecha' => $this->timestamp(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('patrimonio_valorizacion_fk_patrimonio_item', '{{%patrimonio_valorizacion}}', 'patrimonio_item_id', '{{%patrimonio_item}}', 'patrimonio_item_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('patrimonio_valorizacion_fk_metacodigo', '{{%patrimonio_valorizacion}}', 'metacodigo_id', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('patrimonio_valorizacion_fk_usuario_creado', '{{%patrimonio_valorizacion}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('patrimonio_valorizacion_fk_usuario_actualizado', '{{%patrimonio_valorizacion}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'patrimonio_valorizacion_fk_patrimonio_item',
            'patrimonio_valorizacion'
        ); 

        $this->dropForeignKey(
            'patrimonio_valorizacion_fk_metacodigo',
            'patrimonio_valorizacion'
        );   
        
        $this->dropForeignKey(
            'patrimonio_valorizacion_fk_usuario_creado',
            'patrimonio_valorizacion'
        ); 
        
        $this->dropForeignKey(
            'patrimonio_valorizacion_fk_usuario_actualizado',
            'patrimonio_valorizacion'
        );
        
        $this->dropTable('{{%patrimonio_valorizacion}}');
    }
}
