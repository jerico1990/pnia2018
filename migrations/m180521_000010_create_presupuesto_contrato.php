<?php

use yii\db\Migration;

class m180521_000010_create_presupuesto_contrato extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%presupuesto_contrato}}', [//contrato_carta_fianza
            'presupuesto_contrato_id' => $this->primaryKey(),
            'contrato_descripcion'    => $this->string(255),
            'nombre' => $this->string(),
            'estado_regitro' => $this->integer(1)->defaultValue(1),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
       
        $this->addForeignKey('presupuesto_contrato_fk_usuario_creado',
            '{{%presupuesto_contrato}}', 'creado_por',
            '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('presupuesto_contrato_fk_usuario_actualizado',
            '{{%presupuesto_contrato}}', 'actualizado_por',
            '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('presupuesto_cabecera_fk_presupuesto_contrato',
            '{{%presupuesto_cabecera}}', 'presupuesto_contrato_id',
            '{{%presupuesto_contrato}}', 'presupuesto_contrato_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'presupuesto_cabecera_fk_presupuesto_contrato',
            'presupuesto_cabecera'
        );

        $this->dropForeignKey(
            'presupuesto_contrato_fk_usuario_creado',
            'presupuesto_contrato'
        );

        $this->dropForeignKey(
            'presupuesto_contrato_fk_usuario_actualizado',
            'presupuesto_contrato'
        );
        
        $this->dropTable('{{%presupuesto_contrato}}');
    }
}