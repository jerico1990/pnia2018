<?php

use yii\db\Migration;

class m180517_000005_create_table_flujo_requerimiento extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%flujo_requerimiento}}', [
            'flujo_requerimiento_id' => $this->primaryKey(),
            'descripcion' => $this->string(),
            'emisor_persona_id' => $this->integer(11),
            'codigo_flujo' => $this->integer(11),
            'codigo_paso' => $this->integer(11),
            'area_aprobadora_id' => $this->integer(11),
            'estado_paso' => $this->integer(11),
            'fecha_esperada' => $this->timestamp(),
            'monto' => $this->float(),
            'periodo_id' => $this->integer(11),
            'ro_rooc' => $this->integer(1),
            
            //'documento_pnia_id' => $this->integer(11),
            'fecha_instanciacion' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'observacion' => $this->string(),
            'codigo_arbol' => $this->integer(11),
            'flag_procesado' => $this->string(1)->notNull()->defaultExpression('0'),
            'codigo_requerimiento' => $this->integer(11),
            'ticket' => $this->boolean()->defaultExpression('false'),

            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        //$this->addForeignKey('flujo_requerimiento_fk_documento', '{{%flujo_requerimiento}}', 'documento_pnia_id', '{{%documento_pnia}}', 'documento_pnia_id');
                
        
        $this->addForeignKey('flujo_requerimiento_fk_emisor_staff_persona', '{{%flujo_requerimiento}}', 'emisor_persona_id', '{{%staff_persona}}', 'staff_persona_id');

        $this->addForeignKey('flujo_requerimiento_fk_flujo_flujo', '{{%flujo_requerimiento}}', 'codigo_flujo', '{{%flujo_flujo}}', 'flujo_flujo_id');

        $this->addForeignKey('flujo_requerimiento_fk_flujo_paso', '{{%flujo_requerimiento}}', 'codigo_paso', '{{%flujo_paso}}', 'flujo_paso_id');

        $this->addForeignKey('flujo_requerimiento_fk_aprobador_staff_area', '{{%flujo_requerimiento}}', 'area_aprobadora_id', '{{%staff_area}}', 'staff_area_id');
        
        $this->addForeignKey('flujo_requerimiento_fk_estado_metacodigo', '{{%flujo_requerimiento}}', 'estado_paso', '{{%metacodigo}}', 'metacodigo_id');

        $this->addForeignKey('flujo_requerimiento_fk_usuario_creado', '{{%flujo_requerimiento}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        /////de flujo_requerimiento/////
        $this->addForeignKey('flujo_requerimiento_fk_usuario_actualizado', '{{%flujo_requerimiento}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
        
    }

    public function down()
    {
        $this->dropForeignKey(
            'flujo_requerimiento_fk_emisor_staff_persona',
            'flujo_requerimiento'
        );

        $this->dropForeignKey(
            'flujo_requerimiento_fk_flujo_flujo',
            'flujo_requerimiento'
        );

        $this->dropForeignKey(
            'flujo_requerimiento_fk_flujo_paso',
            'flujo_requerimiento'
        );

        $this->dropForeignKey(
            'flujo_requerimiento_fk_aprobador_staff_area',
            'flujo_requerimiento'
        );

        $this->dropForeignKey(
            'flujo_requerimiento_fk_estado_metacodigo',
            'flujo_requerimiento'
        );

        $this->dropForeignKey(
            'flujo_requerimiento_fk_usuario_creado',
            'flujo_requerimiento'
        );

        $this->dropForeignKey(
            'flujo_requerimiento_fk_usuario_actualizado',
            'flujo_requerimiento'
        );

        $this->dropTable('{{%flujo_requerimiento}}');
        
    }
}
