<?php

use yii\db\Migration;

class m180517_000012_create_table_requerimiento_documento extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%requerimiento_documento}}', [
            'requerimiento_documento_id' => $this->primaryKey(),

            'flujo_requerimiento_id' => $this->integer(11)->notNull(),
            'documento_pnia_id' => $this->integer(11)->notNull(),
            
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
        
//        $this->addForeignKey('requerimiento_documento_fk_flujo_requerimiento','{{%requerimiento_documento}}','flujo_requerimiento_id','{{%flujo_requerimiento}}','flujo_requerimiento_id');
        
        $this->addForeignKey('requerimiento_documento_fk_documento_pnia','{{%requerimiento_documento}}','documento_pnia_id','{{%documento_pnia}}','documento_pnia_id');
        
        $this->addForeignKey('requerimiento_documento_fk_usuario_creado', '{{%requerimiento_documento}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('requerimiento_documento_fk_usuario_actualizado', '{{%requerimiento_documento}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
//        $this->dropForeignKey(
//            'requerimiento_documento_fk_flujo_requerimiento',
//            'requerimiento_documento'
//        );

        $this->dropForeignKey(
            'requerimiento_documento_fk_documento_pnia',
            'requerimiento_documento'
        );

        $this->dropForeignKey(
            'requerimiento_documento_fk_usuario_creado',
            'requerimiento_documento'
        );

        $this->dropForeignKey(
            'requerimiento_documento_fk_usuario_actualizado',
            'requerimiento_documento'
        );
        
        $this->dropTable('{{%requerimiento_documento}}');
    }
}