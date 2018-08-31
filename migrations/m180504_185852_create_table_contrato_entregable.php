<?php

use yii\db\Migration;

class m180504_185852_create_table_contrato_entregable extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contrato_entregable}}', [
            'contrato_entregable_id' => $this->primaryKey(),
            'codigo_contrato' => $this->integer(11),
            'descripcion' => $this->string(),
            'estado' => $this->integer(11),
            'monto' => $this->float(),
            'fecha' => $this->dateTime(),
            'codigo_arbol' => $this->integer(11),
            'periodo_id' => $this->integer(11),
            'staff_area_id' => $this->integer(11),
            'flag_conformidad' => $this->integer(),
            'periodo_id' => $this->integer(11)->notNull(),
            'porcentaje' => $this->double(),
            
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('contrato_entregable_fk_staff_area', '{{%contrato_entregable}}', 'staff_area_id', '{{%staff_area}}', 'staff_area_id');
        
        $this->addForeignKey('contrato_entregable_fk_contrato_contrato', '{{%contrato_entregable}}', 'codigo_contrato', '{{%contrato_contrato}}', 'contrato_contrato_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('contrato_entregable_fk_metacodigo', '{{%contrato_entregable}}', 'estado', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('contrato_entregable_fk_usuario_creado', '{{%contrato_entregable}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('contrato_entregable_fk_usuario_actualizado', '{{%contrato_entregable}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'contrato_entregable_fk_staff_area',
            'contrato_entregable'
        );
        
        $this->dropForeignKey(
            'contrato_entregable_fk_contrato_contrato',
            'contrato_entregable'
        );

        $this->dropForeignKey(
            'contrato_entregable_fk_metacodigo',
            'contrato_entregable'
        );

        $this->dropForeignKey(
            'contrato_entregable_fk_usuario_creado',
            'contrato_entregable'
        );

        $this->dropForeignKey(
            'contrato_entregable_fk_usuario_actualizado',
            'contrato_entregable'
        );
        
        $this->dropTable('{{%contrato_entregable}}');
    }
}
