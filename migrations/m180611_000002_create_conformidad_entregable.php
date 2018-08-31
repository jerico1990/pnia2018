<?php

use yii\db\Migration;

class m180611_000002_create_conformidad_entregable extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%conformidad_entregable}}', [
            'conformidad_entregable_id' => $this->primaryKey(),
            'contrato_entregable_id' => $this->integer(11)->notNull(),
            'staff_area_id' => $this->integer(11)->notNull(),

            'flag_conformidad' => $this->integer()->notNull(),
            'documento_pnia_id' => $this->integer(11),
            'observacion' => $this->string(),
            
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
        $this->addForeignKey('conformidad_entregable_fk_documento_pnia', '{{%conformidad_entregable}}', 'documento_pnia_id', '{{%documento_pnia}}', 'documento_pnia_id');
        
        $this->addForeignKey('conformidad_entregable_fk_staff_area','{{%conformidad_entregable}}','staff_area_id','{{%staff_area}}','staff_area_id');
        $this->addForeignKey('conformidad_entregable_fk_contrato_entregable','{{%conformidad_entregable}}','contrato_entregable_id','{{%contrato_entregable}}','contrato_entregable_id');
        
        $this->addForeignKey('conformidad_entregable_fk_usuario_creado', '{{%conformidad_entregable}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('conformidad_entregable_fk_usuario_actualizado', '{{%conformidad_entregable}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'conformidad_entregable_fk_documento_pnia',
            'conformidad_entregable'
        );

        $this->dropForeignKey(
            'conformidad_entregable_fk_staff_area',
            'conformidad_entregable'
        );

        $this->dropForeignKey(
            'conformidad_entregable_fk_contrato_entregable',
            'conformidad_entregable'
        );

        $this->dropForeignKey(
            'conformidad_entregable_fk_usuario_creado',
            'conformidad_entregable'
        );

        $this->dropForeignKey(
            'conformidad_entregable_fk_usuario_actualizado',
            'conformidad_entregable'
        );
        
        $this->dropTable('{{%conformidad_entregable}}');
    }
}