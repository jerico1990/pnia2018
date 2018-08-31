<?php

use yii\db\Migration;

class m180517_000011_create_table_fondo_rendicion_encargo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%fondo_rendicion_encargo}}', [//contrato_carta_fianza
            'fondo_rendicion_encargo_id' => $this->primaryKey(),
            'fondo_fondo_id'         => $this->integer(11), // fk fondo_fondo
            'flujo_requerimiento_id' => $this->integer(11), // fk de flujo_requerimiento
//            'tipo_flujo_metacodigo'  => $this->integer(11),
//            'estado_paso_metacodigo' => $this->integer(11),
            'responsable_persona_id' => $this->integer(11)->notNull(), // fk staff persona
            'correlativo'            => $this->integer()->notNull(),   // autogenerado - count x staff_per
            'total' => $this->float(11)->notNull(),
            'documento_pnia_id' => $this->integer(11)->notNull(),
            'fecha_rendicion'   => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'informe_actividades_logros' => $this->string(),
            
            'actualizado_en'    => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por'   => $this->integer(11)->notNull(),
            'creado_en'         => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por'        => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->addForeignKey('fondo_rendicion_encargo_fk_fondo_fondo', '{{%fondo_rendicion_encargo}}', 'fondo_fondo_id', '{{%fondo_fondo}}', 'fondo_fondo_id');

        $this->addForeignKey('fondo_rendicion_encargo_fk_flujo_requerimiento', '{{%fondo_rendicion_encargo}}', 'flujo_requerimiento_id', '{{%flujo_requerimiento}}', 'flujo_requerimiento_id');

//        $this->addForeignKey('fondo_rendicion_encargo_fk_tipo_metacodigo', '{{%fondo_rendicion_encargo}}', 'tipo_flujo_metacodigo', '{{%metacodigo}}', 'metacodigo_id');

//        $this->addForeignKey('fondo_rendicion_encargo_fk_estado_metacodigo', '{{%fondo_rendicion_encargo}}', 'estado_paso_metacodigo', '{{%metacodigo}}', 'metacodigo_id');

        $this->addForeignKey('fondo_rendicion_encargo_fk_staff_persona', '{{%fondo_rendicion_encargo}}', 'responsable_persona_id', '{{%staff_persona}}', 'staff_persona_id');

        $this->addForeignKey('fondo_rendicion_encargo_fk_documento_pnia', '{{%fondo_rendicion_encargo}}', 'documento_pnia_id', '{{%documento_pnia}}', 'documento_pnia_id');
  
        $this->addForeignKey('fondo_rendicion_encargo_fk_usuario_creado', '{{%fondo_rendicion_encargo}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        
        $this->addForeignKey('fondo_rendicion_encargo_fk_usuario_actualizado', '{{%fondo_rendicion_encargo}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'fondo_rendicion_encargo_fk_fondo_fondo',
            'fondo_rendicion_encargo'
        );

        $this->dropForeignKey(
            'fondo_rendicion_encargo_fk_flujo_requerimiento',
            'fondo_rendicion_encargo'
        );
//
//        $this->dropForeignKey(
//            'fondo_rendicion_encargo_fk_tipo_metacodigo',
//            'fondo_rendicion_encargo'
//        );
//
//        $this->dropForeignKey(
//            'fondo_rendicion_encargo_fk_estado_metacodigo',
//            'fondo_rendicion_encargo'
//        );

        $this->dropForeignKey(
            'fondo_rendicion_encargo_fk_staff_persona',
            'fondo_rendicion_encargo'
        );

        $this->dropForeignKey(
            'fondo_rendicion_encargo_fk_documento_pnia',
            'fondo_rendicion_encargo'
        );

        $this->dropForeignKey(
            'fondo_rendicion_encargo_fk_usuario_creado',
            'fondo_rendicion_encargo'
        );

        $this->dropForeignKey(
            'fondo_rendicion_encargo_fk_usuario_actualizado',
            'fondo_rendicion_encargo'
        );

        $this->dropTable('{{%fondo_rendicion_encargo}}');
    }
}
