<?php

use yii\db\Migration;

class m180521_000012_create_acciones_estrategicas extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%accion_estrategica}}', [//contrato_carta_fianza
            'accion_estrategica_id' => $this->primaryKey(),
            'accion_descripcion'    => $this->string(255),
            'estado_regitro' => $this->integer(1)->defaultValue(1),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
       
        $this->addForeignKey('accion_estrategica_fk_usuario_creado', '{{%accion_estrategica}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('accion_estrategica_fk_usuario_actualizado', '{{%accion_estrategica}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('presupuesto_cabecera_fk_accion_estrategica', '{{%presupuesto_cabecera}}', 'accion_estrategica_id', '{{%accion_estrategica}}', 'accion_estrategica_id');
    }

    public function down()
    {

        $this->dropForeignKey(
            'presupuesto_cabecera_fk_accion_estrategica',
            'presupuesto_cabecera'
        );

        $this->dropForeignKey(
            'accion_estrategica_fk_usuario_actualizado',
            'accion_estrategica'
        );

        $this->dropForeignKey(
            'accion_estrategica_fk_usuario_creado',
            'accion_estrategica'
        );
        
        $this->dropTable('{{%accion_estrategica}}');
    }
}