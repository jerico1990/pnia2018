<?php

use yii\db\Migration;

class m180419_150223_create_table_patrimonio_movimiento extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%patrimonio_movimiento}}', [
            'patrimonio_movimiento_id' => $this->primaryKey(),
            'patrimonio_item_id' => $this->integer(11),
            'metacodigo_id' => $this->integer(11),
            'ubicacion_inicial_id' => $this->integer(11),
            'ubicacion_final_id' => $this->integer(11),
            'persona_aut' => $this->double()->notNull(),
            'persona_rec' => $this->double()->notNull(),
            'fecha_salida' => $this->timestamp()->notNull(),
            'fecha_retorno' => $this->timestamp()->notNull(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('patrimonio_movimiento_fk_patrimonio_item', '{{%patrimonio_movimiento}}', 'patrimonio_item_id', '{{%patrimonio_item}}', 'patrimonio_item_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('patrimonio_movimiento_fk_metacodigo', '{{%patrimonio_movimiento}}', 'metacodigo_id', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('patrimonio_movimiento_fk_ubicacion_inicial', '{{%patrimonio_movimiento}}', 'ubicacion_inicial_id', '{{%ubicacion}}', 'ubicacion_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('patrimonio_movimiento_fk_ubicacion_final', '{{%patrimonio_movimiento}}', 'ubicacion_final_id', '{{%ubicacion}}', 'ubicacion_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('patrimonio_movimiento_fk_usuario_creado', '{{%patrimonio_movimiento}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('patrimonio_movimiento_fk_usuario_actualizado', '{{%patrimonio_movimiento}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {

        $this->dropForeignKey(
            'patrimonio_movimiento_fk_patrimonio_item',
            'patrimonio_movimiento'
        );   
        
        $this->dropForeignKey(
            'patrimonio_movimiento_fk_metacodigo',
            'patrimonio_movimiento'
        ); 
        
        $this->dropForeignKey(
            'patrimonio_movimiento_fk_ubicacion_inicial',
            'patrimonio_movimiento'
        );

        $this->dropForeignKey(
            'patrimonio_movimiento_fk_ubicacion_final',
            'patrimonio_movimiento'
        );   
        
        $this->dropForeignKey(
            'patrimonio_movimiento_fk_usuario_creado',
            'patrimonio_movimiento'
        ); 

        $this->dropForeignKey(
            'patrimonio_movimiento_fk_usuario_actualizado',
            'patrimonio_movimiento'
        );
        
        $this->dropTable('{{%patrimonio_movimiento}}');
    }
}
