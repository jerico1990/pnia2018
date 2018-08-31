<?php

use yii\db\Migration;

class m180504_185910_create_table_contrato_penalidad extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contrato_penalidad}}', [
            'contrato_penalidad_id' => $this->primaryKey(),
            'codigo_contrato' => $this->integer(11),
            'descripcion' => $this->string(),
            'monto_penalidad' => $this->float(),
            'codigo_arbol' => $this->integer(11),
            'periodo_id' => $this->integer(11),
            'staff_area_id' => $this->integer(11),
            
            
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);
        $this->addForeignKey('contrato_penalidad_fk_staff_area', '{{%contrato_penalidad}}', 'staff_area_id', '{{%staff_area}}', 'staff_area_id');

        $this->addForeignKey('contrato_penalidad_fk_contrato_contrato', '{{%contrato_penalidad}}', 'codigo_contrato', '{{%contrato_contrato}}', 'contrato_contrato_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('contrato_penalidad_fk_usuario_creado', '{{%contrato_penalidad}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        
        $this->addForeignKey('contrato_penalidad_fk_usuario_actualizado', '{{%contrato_penalidad}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'contrato_penalidad_fk_staff_area',
            'contrato_penalidad'
        );
        
        $this->dropForeignKey(
            'contrato_penalidad_fk_contrato_contrato',
            'contrato_penalidad'
        );

        $this->dropForeignKey(
            'contrato_penalidad_fk_usuario_creado',
            'contrato_penalidad'
        );

        $this->dropForeignKey(
            'contrato_penalidad_fk_usuario_actualizado',
            'contrato_penalidad'
        );

        $this->dropTable('{{%contrato_penalidad}}');
    }
}
