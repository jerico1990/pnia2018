<?php

use yii\db\Migration;

class m180521_000007_create_presupuesto extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%presupuesto}}', [//contrato_carta_fianza
            'presupuesto_id' => $this->primaryKey(),
            'periodo_id' => $this->integer(11)->notNull(),
            'estado' => $this->integer(11)->notNull(), // en Planificación , Cerrado , En Ejecución, es un Metacodigo automaticamente se ha de cargar [no tocar]
            'presupuesto_cabecera_id'   => $this->integer(11)->notNull(),/// indica a que cabecera pertenece

            'presupuesto_plan_ro'       => $this->float()->defaultValue(0), // el plan ingresado manualmente por los usuarios
            'presupuesto_plan_rooc'     => $this->float()->defaultValue(0), // el plan ingresado manualmente por los usuarios

            'presupuesto_certificado_ro' => $this->float()->defaultValue(0),
            'presupuesto_certificado_rooc' => $this->float()->defaultValue(0),

            'presupuesto_compromiso_ro'     => $this->float()->defaultValue(0),
            'presupuesto_compromiso_rooc'   => $this->float()->defaultValue(0),

            'presupuesto_devengado_ro'   => $this->float()->defaultValue(0),
            'presupuesto_devengado_rooc' => $this->float()->defaultValue(0),

            'presupuesto_girado_ro'     => $this->float()->defaultValue(0),
            'presupuesto_girado_rooc'   => $this->float()->defaultValue(0),

            'presupuesto_pagado_ro'     => $this->float()->defaultValue(0),
            'presupuesto_pagado_rooc'   => $this->float()->defaultValue(0),

            'presupuesto_ejecutado_ro'      => $this->float()->defaultValue(0),
            'presupuesto_ejecutado_rooc'    => $this->float()->defaultValue(0),

            'presupuesto_saldo_ro'   => $this->float()->defaultValue(0), /// = plan - (compromiso + devengado +  certificado + girado + pagado)
            'presupuesto_saldo_rooc' => $this->float()->defaultValue(0), /// = plan - (compromiso + devengado +  certificado + girado + pagado)

            'presupuesto_saldo_anual_ro'    => $this->float()->defaultValue(0), // = 0
            'presupuesto_saldo_anual_rooc'  => $this->float()->defaultValue(0), // = 0

            'presupuesto_ejecucion_posterior_ro'     => $this->float()->defaultValue(0), // es el monto que este periodo ha prestado a presupuestos posteriores
            'presupuesto_ejecucion_posterior_rooc'   => $this->float()->defaultValue(0), // es el monto que este periodo ha prestado a presupuestos posteriores

            'presupuesto_prestado_ro' => $this->float()->defaultValue(0), /// cuanto se ha prestado el periodo actual de los periodos anteriores
            'presupuesto_prestado_rooc' => $this->float()->defaultValue(0),/// cuanto se ha prestado el periodo actual de los periodos anteriores

            'presupuesto_planificado_ro'   => $this->float()->defaultValue(0), // calculado : certificado +  comprometido + devengado + girado + pagado + ejecutado
            'presupuesto_planificado_rooc' => $this->float()->defaultValue(0), // calculado :

            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
        
        $this->addForeignKey('presupuesto_fk_periodo', '{{%presupuesto}}', 'periodo_id', '{{%periodo}}', 'periodo_id');
        $this->addForeignKey('presupuesto_fk_presupuesto_cabecera', '{{%presupuesto}}', 'presupuesto_cabecera_id', '{{%presupuesto_cabecera}}', 'presupuesto_cabecera_id');
        //agregada referencia a metacodigo para estado
        $this->addForeignKey('presupuesto_fk_metacodigo', '{{%presupuesto}}', 'estado', '{{%metacodigo}}', 'metacodigo_id');
        
        $this->addForeignKey('presupuesto_fk_usuario_creado', '{{%presupuesto}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('presupuesto_fk_usuario_actualizado', '{{%presupuesto}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'presupuesto_fk_periodo',
            'presupuesto'
        );

        $this->dropForeignKey(
            'presupuesto_fk_presupuesto_cabecera',
            'presupuesto'
        );

        $this->dropForeignKey(
            'presupuesto_fk_metacodigo',
            'presupuesto'
        );

        $this->dropForeignKey(
            'presupuesto_fk_usuario_creado',
            'presupuesto'
        );

        $this->dropForeignKey(
            'presupuesto_fk_usuario_actualizado',
            'presupuesto'
        );

        $this->dropTable('{{%presupuesto}}');
    }
}