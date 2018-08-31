<?php

use yii\db\Migration;

class m180504_185842_create_table_contrato_contrato extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contrato_contrato}}', [
            'contrato_contrato_id' => $this->primaryKey(),
            'codigo_interno' => $this->string(),
            'entidad_contratista' => $this->integer(11),
            'area_contratante' => $this->integer(11),
            'area_responsable' => $this->integer(11),
            'monto' => $this->float(11),//integer(11),
            'fecha_inicio' => $this->dateTime(),
            'fecha_fin' => $this->dateTime(),
            'objetivos' => $this->string(),
            'contrato_origen' => $this->integer(11),
            'flg_es_staff' => $this->string(),
            //'documento_pnia_id' => $this->integer(11),
            'logistica_proceso_id' => $this->integer(11),
            'adquisicion_id' => $this->integer(11),
            'codigo_arbol' => $this->integer(11),
            'staff_persona_id' => $this->integer(11),
            
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('contrato_contrato_fk_pnia_entidad', '{{%contrato_contrato}}', 'entidad_contratista', '{{%pnia_entidad}}', 'pnia_entidad_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('contrato_contrato_fk_staff_area_contratante', '{{%contrato_contrato}}', 'area_contratante', '{{%staff_area}}', 'staff_area_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('contrato_contrato_fk_staff_area_responsable', '{{%contrato_contrato}}', 'area_responsable', '{{%staff_area}}', 'staff_area_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('contrato_contrato_fk_contrato_contrato', '{{%contrato_contrato}}', 'contrato_origen', '{{%contrato_contrato}}', 'contrato_contrato_id', 'NO ACTION', 'NO ACTION');

        //$this->addForeignKey('contrato_contrato_fk_documento_pnia', '{{%contrato_contrato}}', 'documento_pnia_id', '{{%documento_pnia}}', 'documento_pnia_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('contrato_contrato_fk_staff_persona', '{{%contrato_contrato}}', 'staff_persona_id', '{{%staff_persona}}', 'staff_persona_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('contrato_contrato_fk_usuario_creado', '{{%contrato_contrato}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        
        $this->addForeignKey('contrato_contrato_fk_usuario_actualizado', '{{%contrato_contrato}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'contrato_contrato_fk_staff_persona',
            'contrato_contrato'
        );

        $this->dropForeignKey(
            'contrato_contrato_fk_pnia_entidad',
            'contrato_contrato'
        );

        $this->dropForeignKey(
            'contrato_contrato_fk_staff_area_contratante',
            'contrato_contrato'
        );

        $this->dropForeignKey(
            'contrato_contrato_fk_staff_area_responsable',
            'contrato_contrato'
        );

        $this->dropForeignKey(
            'contrato_contrato_fk_contrato_contrato',
            'contrato_contrato'
        );

//        $this->dropForeignKey(
//            'contrato_contrato_fk_documento_pnia',
//            'contrato_contrato'
//        );

        $this->dropForeignKey(
            'contrato_contrato_fk_usuario_creado',
            'contrato_contrato'
        );

        $this->dropForeignKey(
            'contrato_contrato_fk_usuario_actualizado',
            'contrato_contrato'
        );
        $this->dropTable('{{%contrato_contrato}}');
    }
}
