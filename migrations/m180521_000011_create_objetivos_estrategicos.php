<?php

use yii\db\Migration;

class m180521_000011_create_objetivos_estrategicos extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%objetivo_estrategico}}', [//contrato_carta_fianza
            'objetivo_estrategico_id' => $this->primaryKey(),
            'objetivo_descripcion'    => $this->string(255),
            'estado_regitro' => $this->integer(1)->defaultValue(1),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
       
        $this->addForeignKey('objetivo_estrategico_fk_usuario_creado',
            '{{%objetivo_estrategico}}', 'creado_por',
            '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('objetivo_estrategico_fk_usuario_actualizado',
        '{{%objetivo_estrategico}}', 'actualizado_por',
        '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('presupuesto_cabecera_fk_objetivo_estrategico',
            '{{%presupuesto_cabecera}}', 'objetivo_estrategico_id',
            '{{%objetivo_estrategico}}', 'objetivo_estrategico_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'presupuesto_cabecera_fk_objetivo_estrategico',
            'presupuesto_cabecera'
        );

        $this->dropForeignKey(
            'objetivo_estrategico_fk_usuario_creado',
            'objetivo_estrategico'
        );

        $this->dropForeignKey(
            'objetivo_estrategico_fk_usuario_actualizado',
            'objetivo_estrategico'
        );
        
        $this->dropTable('{{%objetivo_estrategico}}');
    }
}