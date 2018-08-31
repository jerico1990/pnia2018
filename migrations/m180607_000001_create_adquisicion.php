<?php

use yii\db\Migration;

class m180607_000001_create_adquisicion extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%adquisicion}}', [//contrato_carta_fianza
            'adquisicion_id' => $this->primaryKey(),
            'flujo_requerimiento_id' => $this->integer(11)->notNull(),
            'codigo_referencia' => $this->integer(),
            'referencia_actividad' => $this->string(),
            'nombre_firma' => $this->string(),
            'monto_adjudicado' => $this->float(),
            'monto_ejecutado' => $this->float(),
            'prestamo' => $this->integer(1),
            'componente' => $this->integer(11),
            'tipo_revision'=> $this->integer(11)->notNull(),
            'categoria' => $this->integer(11)->notNull(),
            'enfoque_mercado' => $this->integer(11)->notNull(),
            'monto_estimado' => $this->float(),
            'estado_proceso' => $this->integer(11)->notNull(),
            'estado_actividad' => $this->integer(11)->notNull(),
            'ticket' => $this->boolean()->defaultExpression('false'),
            
            
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
       

        $this->addForeignKey('adquisicion_fk_estado_proceso', '{{%adquisicion}}', 'estado_proceso', '{{%metacodigo}}', 'metacodigo_id');
        $this->addForeignKey('adquisicion_fk_estado_actividad', '{{%adquisicion}}', 'estado_actividad', '{{%metacodigo}}', 'metacodigo_id');
        $this->addForeignKey('adquisicion_fk_tipo', '{{%adquisicion}}', 'tipo_revision', '{{%metacodigo}}', 'metacodigo_id');
        $this->addForeignKey('adquisicion_fk_categoria', '{{%adquisicion}}', 'categoria', '{{%metacodigo}}', 'metacodigo_id');
        $this->addForeignKey('adquisicion_fk_flujo_requerimiento', '{{%adquisicion}}', 'flujo_requerimiento_id', '{{%flujo_requerimiento}}', 'flujo_requerimiento_id');
        $this->addForeignKey('adquisicion_fk_usuario_creado', '{{%adquisicion}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('adquisicion_fk_usuario_actualizado', '{{%adquisicion}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'adquisicion_fk_estado_proceso',
            'adquisicion'
        );
        $this->dropForeignKey(
            'adquisicion_fk_estado_actividad',
            'adquisicion'
        );
        $this->dropForeignKey(
            'adquisicion_fk_tipo',
            'adquisicion'
        );

        $this->dropForeignKey(
            'adquisicion_fk_categoria',
            'adquisicion'
        );
        $this->dropForeignKey(
            'adquisicion_fk_flujo_requerimiento',
            'adquisicion'
        );
        $this->dropForeignKey(
            'adquisicion_fk_usuario_creado',
            'adquisicion'
        );

        $this->dropForeignKey(
            'adquisicion_fk_usuario_actualizado',
            'adquisicion'
        );
        
        $this->dropTable('{{%adquisicion}}');
    }
}