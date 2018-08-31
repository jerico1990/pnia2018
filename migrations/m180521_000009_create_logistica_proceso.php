<?php

use yii\db\Migration;

class m180521_000009_create_logistica_proceso extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%logistica_proceso}}', [//contrato_carta_fianza
            'logistica_proceso_id' => $this->primaryKey(),
            'proyecto_id' => $this->integer(11)->notNull(),
            'nombre' => $this->string(),
            'codigo' => $this->string(),
            'componente_id' => $this->integer(11)->notNull(),
            'monto_rooc_bm' => $this->float(),
            'monto_rooc_bid' => $this->float(),
            'monto_ro' => $this->float(),
            'monto_total' => $this->float(),
            'categoria' => $this->integer(11)->notNull(),
            'tipo' => $this->integer(11)->notNull(),
            'tdr_plan' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'tdr_real' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'expresion_plan' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'expresion_real' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'evaluacion_plan' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'evaluacion_real' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'notificacion_plan' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'notificacion_real' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'firma_plan' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'firma_real' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'adenda_plan' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'adenda_real' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'termino_plan' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'termino_real' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'estado' => $this->integer(11)->notNull(),
            'documento_pnia_id' => $this->integer(11),// agregado
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
        
        $this->addForeignKey('logistica_proceso_fk_periodo', '{{%logistica_proceso}}', 'proyecto_id', '{{%proyecto}}', 'proyecto_id');
        $this->addForeignKey('logistica_proceso_fk_metacodigo_categoria', '{{%logistica_proceso}}', 'categoria', '{{%metacodigo}}', 'metacodigo_id');
        $this->addForeignKey('logistica_proceso_fk_metacodigo_tipo', '{{%logistica_proceso}}', 'tipo', '{{%metacodigo}}', 'metacodigo_id');
        $this->addForeignKey('logistica_proceso_fk_metacodigo_estado', '{{%logistica_proceso}}', 'estado', '{{%metacodigo}}', 'metacodigo_id');

        //agregada fk a contrato puesta aqui para que no de error las migraciones
        //$this->addForeignKey('contrato_contrato_fk_logistica_proceso', '{{%contrato_contrato}}', 'logistica_proceso_id', '{{%logistica_proceso}}', 'logistica_proceso_id');
        $this->addForeignKey('logistica_proceso_fk_contrato_contrato', '{{%logistica_proceso}}', 'logistica_proceso_id', '{{%contrato_contrato}}', 'contrato_contrato_id');
        //agregada fk de documentos a logistica_proceso
        //$this->addForeignKey('documento_pnia_fk_logistica_proceso', '{{%documento_pnia}}', 'logistica_proceso_id', '{{%logistica_proceso}}', 'logistica_proceso_id');
        $this->addForeignKey('logistica_proceso_fk_documento_pnia','{{%logistica_proceso}}','documento_pnia_id','{{%documento_pnia}}','documento_pnia_id');
        
        $this->addForeignKey('logistica_proceso_fk_usuario_creado', '{{%logistica_proceso}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('logistica_proceso_fk_usuario_actualizado', '{{%logistica_proceso}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'logistica_proceso_fk_periodo',
            'logistica_proceso'
        );

        $this->dropForeignKey(
            'logistica_proceso_fk_metacodigo_categoria',
            'logistica_proceso'
        );

        $this->dropForeignKey(
            'logistica_proceso_fk_metacodigo_tipo',
            'logistica_proceso'
        );

        $this->dropForeignKey(
            'logistica_proceso_fk_metacodigo_estado',
            'logistica_proceso'
        );

        // $this->dropForeignKey(
        //     'contrato_contrato_fk_logistica_proceso',
        //     'contrato_contrato'
        // );

        // $this->dropForeignKey(
        //     'documento_pnia_fk_logistica_proceso',
        //     'documento_pnia'
        // );

        $this->dropForeignKey(
            'logistica_proceso_fk_usuario_creado',
            'logistica_proceso'
        );

        $this->dropForeignKey(
            'logistica_proceso_fk_usuario_actualizado',
            'logistica_proceso'
        );
        
        $this->dropTable('{{%logistica_proceso}}');
    }
}