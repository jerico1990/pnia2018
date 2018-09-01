<?php

use yii\db\Migration;

class m180517_000014_create_table_requerimiento_detalle extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%requerimiento_detalle}}', [
            'requerimiento_detalle_id' => $this->primaryKey(),
            'requerimiento_id' => $this->integer(11),
            'linea_nivel_id' => $this->integer(11),

            //'flujo_requerimiento_id' => $this->integer(11), //fk a flujo requerimiento aqui?

            //para todos
            'descripcion' => $this->string(500),
            'concepto' => $this->string(250),
            'unidad_medida' => $this->string(50),
            'cantidad' => $this->integer(11),
            'costo_unitario' => $this->float(10,2),
            'monto_total' => $this->float(10,2),
            'rooc' => $this->float(10,2),
            'ro' => $this->float(10,2),

            //bien
            'especificacion_tecnica' => $this->text(),
            'tiempo_entrega' => $this->string(50),
            'tipo_garantia_id' => $this->integer(11),
            'garantia_cantidad' => $this->integer(11),
            'lugar_entrega' => $this->string(), //fk a ubicaciones - utilitario_ubigeo_id
            'fecha_entrega' => $this->timestamp(),
            'forma_pago' => $this->text(),
            'resumen_especificacion_tecnica' => $this->text(),
            'otras_caractaristicas' => $this->text(),
            'forma_entrega' => $this->integer(11),
            'anio_fabricacion' => $this->integer(11),
            'lugar_fabricacion' => $this->string(),
            'staff_area_id' => $this->text(), // area que pidio


            //servicio


            'situacion_requerimiento_detalle_id' => $this->integer(),
            'actualizado_en' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11),
            'creado_en' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11),
        ], $tableOptions);

        /*
        $this->createTable('{{%requerimiento_detalle}}', [
            'requerimiento_detalle_id' => $this->primaryKey(),
            'codigo_arbol' => $this->integer(11),
            'periodo_id' => $this->integer(11),
            'monto' => $this->float(),
            'ro_rooc' => $this->integer(1),
            'entregable_id' => $this->integer(11),
            'penalidad_id' => $this->integer(11),
            'flujo_requerimiento_id' => $this->integer(11), //fk a flujo requerimiento aqui?

            //para todos
            'cantidad' => $this->integer(),
            //esto es string?
            'unidad_medida_cantidad' => $this->string(),
            'costo_unitario' => $this->integer(),
            'staff_area_id' => $this->integer(11)->notNull(), //area responsable - fk staff_area
            'bien_servicio' => $this->string()->notNull(),

            //para bien o servicio - cambiar el nombre dinamicamente del campo(?)
            'descripcion_bien_servicio' => $this->string(),
            'especificacion_tecnica_o_tdr' => $this->string(),
            'tiempo_garantia_numero_meses' => $this->integer(),


            //campos para bien
            'lugar_entrega' => $this->string(), //fk a ubicaciones - utilitario_ubigeo_id
            'forma_pago' => $this->string()->notNull(), //fk a metacodigo - metacodigo_id

            //para servicios
            'duracion_servicio' => $this->integer(),
            'monto_total_contrato_fake' => $this->float(),
            'staff_persona_id' => $this->integer(11), //Usuario Responsable del servicio


            'actualizado_en' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11),
            'creado_en' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11),
        ], $tableOptions);
        */
        /*
        $this->addForeignKey('requerimiento_detalle_fk_flujo_requerimiento', '{{%requerimiento_detalle}}', 'flujo_requerimiento_id', '{{%flujo_requerimiento}}', 'flujo_requerimiento_id');

        $this->addForeignKey('requerimiento_detalle_fk_staff_area', '{{%requerimiento_detalle}}', 'staff_area_id', '{{%staff_area}}', 'staff_area_id');

        $this->addForeignKey('requerimiento_detalle_fk_utilitario_ubigeo', '{{%requerimiento_detalle}}', 'lugar_entrega', '{{%utilitario_ubigeo}}', 'utilitario_ubigeo_id');

        //$this->addForeignKey('requerimiento_detalle_fk_metacodigo', '{{%requerimiento_detalle}}', 'forma_pago', '{{%metacodigo}}', 'metacodigo_id');

        $this->addForeignKey('requerimiento_detalle_fk_staff_persona', '{{%requerimiento_detalle}}', 'staff_persona_id', '{{%staff_persona}}', 'staff_persona_id');


        $this->addForeignKey('requerimiento_detalle_fk_usuario_creado', '{{%requerimiento_detalle}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('requerimiento_detalle_fk_usuario_actualizado', '{{%requerimiento_detalle}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
        */

    }

    public function down()
    {
//        $this->dropForeignKey(
//            'requerimiento_detalle_fk_metacodigo',
//            'requerimiento_detalle'
//        );
        /*
        $this->dropForeignKey(
            'requerimiento_detalle_fk_utilitario_ubigeo',
            'requerimiento_detalle'
        );

        $this->dropForeignKey(
            'requerimiento_detalle_fk_staff_area',
            'requerimiento_detalle'
        );

        $this->dropForeignKey(
            'requerimiento_detalle_fk_flujo_requerimiento',
            'requerimiento_detalle'
        );

        $this->dropForeignKey(
            'requerimiento_detalle_fk_usuario_creado',
            'requerimiento_detalle'
        );

        $this->dropForeignKey(
            'requerimiento_detalle_fk_usuario_actualizado',
            'requerimiento_detalle'
        );

        $this->dropTable('{{%requerimiento_detalle}}');
        */
    }
}
