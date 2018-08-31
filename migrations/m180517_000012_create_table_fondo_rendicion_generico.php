<?php

use yii\db\Migration;

class m180517_000012_create_table_fondo_rendicion_generico extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%fondo_rendicion_generico}}', [//contrato_carta_fianza
            'fondo_rendicion_generico_id'   => $this->primaryKey(),
            'fondo_rendicion_viatico_id'    => $this->integer(11),
            'fondo_rendicion_caja_chica_id' => $this->integer(11),
            'fondo_rendicion_encargo_id'    => $this->integer(11),
            'tipo_afecto_igv_metacodigo'    => $this->integer(11)->notNull(),
            'tipo_bien_servicio_metacodigo' => $this->integer(11),
            'tipo_documento_metacodigo'     => $this->integer(11)->notNull(),
            'proveedor_pnia_entidad_id'     => $this->integer(11)->notNull(),

            'importe' => $this->float(),
            'importe_caja_chica' => $this->float(),
            'importe_viatico' => $this->float(),
            'importe_entrega' => $this->float(),
            'importe_gravado'       => $this->float(),
            'importe_no_gravado'    => $this->float(),

            'serie_numero'  => $this->string(),
            'ruc'           => $this->string(11)->notNull(),
            'detalle_gasto' => $this->string(),

            'fecha_documento' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),

            'actualizado_en'  => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en'       => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por'      => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fondo_rendicion_generico_fk_fondo_rendicion_viatico', '{{%fondo_rendicion_generico}}', 'fondo_rendicion_viatico_id', '{{%fondo_rendicion_viatico}}', 'fondo_rendicion_viatico_id');
        $this->addForeignKey('fondo_rendicion_generico_fk_fondo_rendicion_cajachica', '{{%fondo_rendicion_generico}}', 'fondo_rendicion_caja_chica_id', '{{%fondo_rendicion_caja_chica}}', 'fondo_rendicion_caja_chica_id');
        $this->addForeignKey('fondo_rendicion_generico_fk_fondo_rendicion_encargo', '{{%fondo_rendicion_generico}}', 'fondo_rendicion_encargo_id', '{{%fondo_rendicion_encargo}}', 'fondo_rendicion_encargo_id');
        //$this->addForeignKey('fondo_rendicion_generico_fk_afecto_igv', '{{%fondo_rendicion_generico}}', 'tipo_afecto_igv_metacodigo', '{{%metacodigo}}', 'metacodigo_id');

        $this->addForeignKey('fondo_rendicion_generico_fk_bien_servicio', '{{%fondo_rendicion_generico}}', 'tipo_bien_servicio_metacodigo', '{{%metacodigo}}', 'metacodigo_id');

        $this->addForeignKey('fondo_rendicion_generico_fk_tipo_documento', '{{%fondo_rendicion_generico}}', 'tipo_documento_metacodigo', '{{%metacodigo}}', 'metacodigo_id');
        
        $this->addForeignKey('fondo_rendicion_generico_fk_pnia_entidad', '{{%fondo_rendicion_generico}}', 'proveedor_pnia_entidad_id', '{{%pnia_entidad}}', 'pnia_entidad_id');

        $this->addForeignKey('fondo_rendicion_generico_fk_usuario_creado', '{{%fondo_rendicion_generico}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('fondo_rendicion_generico_fk_usuario_actualizado', '{{%fondo_rendicion_generico}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'fondo_rendicion_generico_fk_fondo_rendicion_viatico',
            'fondo_rendicion_generico'
        );

        $this->dropForeignKey(
            'fondo_rendicion_generico_fk_fondo_rendicion_cajachica',
            'fondo_rendicion_generico'
        );

        $this->dropForeignKey(
            'fondo_rendicion_generico_fk_fondo_rendicion_encargo',
            'fondo_rendicion_generico'
        );

//        $this->dropForeignKey(
//            'fondo_rendicion_generico_fk_afecto_igv',
//            'fondo_rendicion_generico'
//        );

        $this->dropForeignKey(
            'fondo_rendicion_generico_fk_bien_servicio',
            'fondo_rendicion_generico'
        );

        $this->dropForeignKey(
            'fondo_rendicion_generico_fk_tipo_documento',
            'fondo_rendicion_generico'
        );

        $this->dropForeignKey(
            'fondo_rendicion_generico_fk_pnia_entidad',
            'fondo_rendicion_generico'
        );

        $this->dropForeignKey(
            'fondo_rendicion_generico_fk_usuario_creado',
            'fondo_rendicion_generico'
        );

        $this->dropForeignKey(
            'fondo_rendicion_generico_fk_usuario_actualizado',
            'fondo_rendicion_generico'
        );

        $this->dropTable('{{%fondo_rendicion_generico}}');
    }
}
