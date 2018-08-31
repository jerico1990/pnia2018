<?php

use yii\db\Migration;

class m180517_000006_create_table_fondo_fondo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%fondo_fondo}}', [//contrato_carta_fianza
            'fondo_fondo_id' => $this->primaryKey(),

            'responsable_persona_id' => $this->integer(11)->notNull(),
            'requerimiento_flujo_id' => $this->integer(11)->notNull(),
            'tipo_flujo_metacodigo' => $this->integer(11)->notNull(),
            'resolucion_directoral_pnia_documento_id' => $this->integer(11),
            'banco_entidad_financiera' => $this->integer(11),
            'motivo' => $this->string(),
            'saldo_anterior_bienes' => $this->float(),
            'saldo_anterior_servicios' => $this->float(),
            'saldo_actual_bienes' => $this->float(),
            'saldo_actual_servicios' => $this->float(),
            'fecha_inicio' => $this->timestamp(),
            'fecha_fin' => $this->timestamp(),
            'total_bienes' => $this->float(),
            'total_servicios' => $this->float(),
            'total_entregado' => $this->float(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
            'ticket' => $this->boolean()->defaultExpression('false'),
        ], $tableOptions);

        $this->addForeignKey('fondo_fondo_fk_staff_persona', '{{%fondo_fondo}}', 'responsable_persona_id', '{{%staff_persona}}', 'staff_persona_id');

        $this->addForeignKey('fondo_fondo_fk_flujo_requerimiento', '{{%fondo_fondo}}', 'requerimiento_flujo_id', '{{%flujo_requerimiento}}', 'flujo_requerimiento_id');//A flujo_requerimiento

        $this->addForeignKey('fondo_fondo_fk_tipo_flujo_metacodigo', '{{%fondo_fondo}}', 'tipo_flujo_metacodigo', '{{%metacodigo}}', 'metacodigo_id');

        $this->addForeignKey('fondo_fondo_fk_documento_pnia', '{{%fondo_fondo}}', 'resolucion_directoral_pnia_documento_id', '{{%documento_pnia}}', 'documento_pnia_id');

        $this->addForeignKey('contrato_carta_fianza_fk_pnia_ent_financiera_fondo', '{{%fondo_fondo}}', 'banco_entidad_financiera', '{{%pnia_ent_financiera}}', 'pnia_ent_financiera_id');
        
        $this->addForeignKey('fondo_fondo_fk_usuario_creado', '{{%fondo_fondo}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('fondo_fondo_fianza_fk_usuario_actualizado', '{{%fondo_fondo}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {

        $this->dropForeignKey(
            'fondo_fondo_fk_staff_persona',
            'fondo_fondo'
        );
        
        $this->dropForeignKey(
            'fondo_fondo_fk_flujo_requerimiento',
            'fondo_fondo'
        );

        $this->dropForeignKey(
            'fondo_fondo_fk_tipo_flujo_metacodigo',
            'fondo_fondo'
        );

        $this->dropForeignKey(
            'fondo_fondo_fk_documento_pnia',
            'fondo_fondo'
        );

        $this->dropForeignKey(
            'contrato_carta_fianza_fk_pnia_ent_financiera_fondo',
            'fondo_fondo'
        );

        $this->dropForeignKey(
            'fondo_fondo_fk_usuario_creado',
            'fondo_fondo'
        );

        $this->dropForeignKey(
            'fondo_fondo_fianza_fk_usuario_actualizado',
            'fondo_fondo'
        );

        $this->dropTable('{{%fondo_fondo}}');
    }
}
