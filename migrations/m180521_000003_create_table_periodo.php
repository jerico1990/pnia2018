<?php

use yii\db\Migration;

class m180521_000003_create_table_periodo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%periodo}}', [//contrato_carta_fianza
            'periodo_id' => $this->primaryKey(),
            'anho' => $this->integer(4)->notNull(),
            'trimestre' => $this->integer(11)->notNull(),
            'mes' => $this->integer(11)->notNull(),
            'estatus_abierto' => $this->integer(1)->defaultValue(1),//0 - Clausurado / 1 Abierto
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->addForeignKey('periodo_fk_usuario_creado', '{{%periodo}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('periodo_fk_usuario_actualizado', '{{%periodo}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');



        /////de flujo_requerimiento/////
        $this->addForeignKey('flujo_requerimiento_fk_periodo', '{{%flujo_requerimiento}}', 'periodo_id', '{{%periodo}}', 'periodo_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'periodo_fk_usuario_creado',
            'periodo'
        );

        $this->dropForeignKey(
            'periodo_fk_usuario_actualizado',
            'periodo'
        );





        /////de flujo_requerimiento/////
        $this->dropForeignKey(
            'flujo_requerimiento_fk_periodo',
            'flujo_requerimiento'
        );
        
        $this->dropTable('{{%periodo}}');
    }
}
