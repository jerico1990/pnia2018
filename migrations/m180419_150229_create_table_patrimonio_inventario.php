<?php

use yii\db\Migration;

class m180419_150229_create_table_patrimonio_inventario extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //inventario como log
        $this->createTable('{{%patrimonio_inventario}}', [
            'patrimonio_inventario_id' => $this->primaryKey(),
            'patrimonio_item_id' => $this->integer(11),
            'metacodigo_condicion_id' => $this->integer(11), 
            'metacodigo_estado_id' => $this->integer(11),
            'documento_pnia_id' => $this->integer(11),
            'ubicacion_id' => $this->integer(11),
            'persona_aut' => $this->integer(11),  //autorizacion responsable //encargada del activo
            'persona_inv' => $this->integer(11), //autorizacion inventariador
            'fecha_inventario' => $this->timestamp(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('patrimonio_inventario_fk_patrimonio_item', '{{%patrimonio_inventario}}', 'patrimonio_item_id', '{{%patrimonio_item}}', 'patrimonio_item_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('patrimonio_inventario_fk_metacodigo_condicion', '{{%patrimonio_inventario}}', 'metacodigo_condicion_id', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('patrimonio_inventario_fk_documento_pnia', '{{%patrimonio_inventario}}', 'documento_pnia_id', '{{%documento_pnia}}', 'documento_pnia_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('patrimonio_inventario_fk_ubicacion', '{{%patrimonio_inventario}}', 'ubicacion_id', '{{%ubicacion}}', 'ubicacion_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('patrimonio_inventario_fk_metacodigo_estado', '{{%patrimonio_inventario}}', 'metacodigo_estado_id', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');
        
        
        $this->addForeignKey('patrimonio_inventario_fk_usuario_creado', '{{%patrimonio_inventario}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('patrimonio_inventario_fk_usuario_actualizado', '{{%patrimonio_inventario}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {

        $this->dropForeignKey(
            'patrimonio_inventario_fk_patrimonio_item',
            'patrimonio_inventario'
        );

        $this->dropForeignKey(
            'patrimonio_inventario_fk_metacodigo_condicion',
            'patrimonio_inventario'
        );

        $this->dropForeignKey(
            'patrimonio_inventario_fk_documento_pnia',
            'patrimonio_inventario'
        );

        $this->dropForeignKey(
            'patrimonio_inventario_fk_ubicacion',
            'patrimonio_inventario'
        );

        $this->dropForeignKey(
            'patrimonio_inventario_fk_metacodigo_estado',
            'patrimonio_inventario'
        );

        $this->dropForeignKey(
            'patrimonio_inventario_fk_usuario_creado',
            'patrimonio_inventario'
        );

        $this->dropForeignKey(
            'patrimonio_inventario_fk_usuario_actualizado',
            'patrimonio_inventario'
        );
        
        $this->dropTable('{{%patrimonio_inventario}}');
    }
}
