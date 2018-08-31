<?php

use yii\db\Migration;

class m180504_185926_create_table_contrato_carta_fianza extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contrato_carta_fianza}}', [
            'contrato_carta_fianza_id' => $this->primaryKey(),
            'codigo_interno' => $this->string(),
            'entidad_emisora' => $this->integer(),
            'entidad_afianzada' => $this->integer(),
            'contrato' => $this->integer(),
            'periodo_inicio' => $this->dateTime(),
            'periodo_fin' => $this->dateTime(),
            'monto' => $this->float(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('contrato_carta_fianza_fk_pnia_ent_financiera', '{{%contrato_carta_fianza}}', 'entidad_emisora', '{{%pnia_ent_financiera}}', 'pnia_ent_financiera_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('contrato_carta_fianza_fk_pnia_entidad', '{{%contrato_carta_fianza}}', 'entidad_afianzada', '{{%pnia_entidad}}', 'pnia_entidad_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('contrato_carta_fianza_fk_contrato_contrato', '{{%contrato_carta_fianza}}', 'contrato', '{{%contrato_contrato}}', 'contrato_contrato_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('contrato_carta_fianza_fk_usuario_creado', '{{%contrato_carta_fianza}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('contrato_carta_fianza_fk_usuario_actualizado', '{{%contrato_carta_fianza}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'contrato_carta_fianza_fk_pnia_ent_financiera',
            'contrato_carta_fianza'
        );

        $this->dropForeignKey(
            'contrato_carta_fianza_fk_pnia_entidad',
            'contrato_carta_fianza'
        );

        $this->dropForeignKey(
            'contrato_carta_fianza_fk_contrato_contrato',
            'contrato_carta_fianza'
        );

        $this->dropForeignKey(
            'contrato_carta_fianza_fk_usuario_creado',
            'contrato_carta_fianza'
        );

        $this->dropForeignKey(
            'contrato_carta_fianza_fk_usuario_actualizado',
            'contrato_carta_fianza'
        );

        $this->dropTable('{{%contrato_carta_fianza}}');
    }
}
