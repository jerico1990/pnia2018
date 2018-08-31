<?php

use yii\db\Migration;

class m180517_000013_create_table_contrato_documento extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contrato_documento}}', [
            'contrato_documento_id' => $this->primaryKey(),

            'contrato_id' => $this->integer(11),
            'documento_pnia_id' => $this->integer(11)->notNull(),
            'patrimonio_item_id' => $this->integer(11),
            'patrimonio_inventario_id' => $this->integer(11),
            

            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
        
        $this->addForeignKey('contrato_documento_fk_flujo_requerimiento','{{%contrato_documento}}','contrato_id','{{%contrato_contrato}}','contrato_contrato_id');
        
        $this->addForeignKey('contrato_documento_fk_documento_pnia','{{%contrato_documento}}','documento_pnia_id','{{%documento_pnia}}','documento_pnia_id');
        
        $this->addForeignKey('contrato_documento_fk_patrimonio_item','{{%contrato_documento}}','patrimonio_item_id','{{%patrimonio_item}}','patrimonio_item_id');
        $this->addForeignKey('contrato_documento_fk_patrimonio_inventario','{{%contrato_documento}}','patrimonio_inventario_id','{{%patrimonio_inventario}}','patrimonio_inventario_id');
        
        $this->addForeignKey('contrato_documento_fk_usuario_creado', '{{%contrato_documento}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('contrato_documento_fk_usuario_actualizado', '{{%contrato_documento}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        
        $this->dropForeignKey(
            'contrato_documento_fk_patrimonio_inventario',
            'contrato_documento'
        );
         
        $this->dropForeignKey(
            'contrato_documento_fk_patrimonio_item',
            'contrato_documento'
        );
        
        $this->dropForeignKey(
            'contrato_documento_fk_flujo_requerimiento',
            'contrato_documento'
        );

        $this->dropForeignKey(
            'contrato_documento_fk_documento_pnia',
            'contrato_documento'
        );

        $this->dropForeignKey(
            'contrato_documento_fk_usuario_creado',
            'contrato_documento'
        );

        $this->dropForeignKey(
            'contrato_documento_fk_usuario_actualizado',
            'contrato_documento'
        );
        
        $this->dropTable('{{%contrato_documento}}');
    }
}