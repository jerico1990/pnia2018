<?php

use yii\db\Migration;

class m180517_000010_create_table_fondo_rendicion_caja_chica extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%fondo_rendicion_caja_chica}}', [
            'fondo_rendicion_caja_chica_id' => $this->primaryKey(),
            'fondo_fondo_id'         => $this->integer(11), // fk fondo_fondo
            'flujo_requerimiento_id' => $this->integer(11), // fk de flujo_requerimiento
//            'tipo_flujo_metacodigo'  => $this->integer(11), // fk Metacodigo
//            'estado_paso_metacodigo' => $this->integer(11), // fk Metacodigo
            'responsable_persona_id' => $this->integer(11), // fk staff personapersona
            'total_rendicion' => $this->float(),
            'documento_pnia'  => $this->integer(11),
            'fecha_rendicion' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'correlativo'     => $this->integer(11),
            'actualizado_en'  => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en'       => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por'      => $this->integer(11)->notNull(),
        ], $tableOptions);


        $this->addForeignKey('fondo_rendicion_caja_chica_fk_fondo_fondo', '{{%fondo_rendicion_caja_chica}}', 'fondo_fondo_id', '{{%fondo_fondo}}', 'fondo_fondo_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fondo_rendicion_caja_chica_fk_flujo_requerimiento', '{{%fondo_rendicion_caja_chica}}', 'flujo_requerimiento_id', '{{%flujo_requerimiento}}', 'flujo_requerimiento_id', 'NO ACTION', 'NO ACTION');
//        $this->addForeignKey('fondo_rendicion_caja_chica_fk_tipo_flujo_metacodigo', '{{%fondo_rendicion_caja_chica}}', 'tipo_flujo_metacodigo', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');
//        $this->addForeignKey('fondo_rendicion_caja_chica_fk_estado_paso_metacodigo', '{{%fondo_rendicion_caja_chica}}', 'estado_paso_metacodigo', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fondo_rendicion_caja_chica_fk_staff_persona', '{{%fondo_rendicion_caja_chica}}', 'responsable_persona_id', '{{%staff_persona}}', 'staff_persona_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fondo_rendicion_caja_chica_fk_documento_pnia', '{{%fondo_rendicion_caja_chica}}', 'documento_pnia', '{{%documento_pnia}}', 'documento_pnia_id', 'NO ACTION', 'NO ACTION');
        
         $this->addForeignKey('fondo_rendicion_caja_chica_fk_usuario_creado', '{{%fondo_rendicion_caja_chica}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('fondo_rendicion_caja_chica_fk_usuario_actualizado', '{{%fondo_rendicion_caja_chica}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
//        $this->dropForeignKey(
//            'fondo_rendicion_caja_chica_fk_tipo_flujo_metacodigo',
//            'fondo_rendicion_caja_chica'
//        );

//        $this->dropForeignKey(
//            'fondo_rendicion_caja_chica_fk_estado_paso_metacodigo',
//            'fondo_rendicion_caja_chica'
//        );

        $this->dropForeignKey(
            'fondo_rendicion_caja_chica_fk_fondo_fondo',
            'fondo_rendicion_caja_chica'
        );

        $this->dropForeignKey(
            'fondo_rendicion_caja_chica_fk_flujo_requerimiento',
            'fondo_rendicion_caja_chica'
        );

        $this->dropForeignKey(
            'fondo_rendicion_caja_chica_fk_staff_persona',
            
            'fondo_rendicion_caja_chica'
        );

        $this->dropForeignKey(
            'fondo_rendicion_caja_chica_fk_documento_pnia',
            'fondo_rendicion_caja_chica'
        );

        $this->dropForeignKey(
            'fondo_rendicion_caja_chica_fk_usuario_creado',
            'fondo_rendicion_caja_chica'
        );

        $this->dropForeignKey(
            'fondo_rendicion_caja_chica_fk_usuario_actualizado',
            'fondo_rendicion_caja_chica'
        );

        $this->dropTable('{{%fondo_rendicion_caja_chica}}');
    }
}
