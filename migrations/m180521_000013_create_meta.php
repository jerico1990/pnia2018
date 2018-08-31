<?php

use yii\db\Migration;

class m180521_000013_create_meta extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%codigo_meta}}',
            [   'codigo_meta_id' => $this->primaryKey(),
                'descripcion' => $this->string(255),
                'unidad_medida_id' => $this->integer(11)->notNull(),
                'estado_regitro' => $this->integer(1)->defaultValue(1),
                'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'actualizado_por' => $this->integer(11)->notNull(),
                'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'creado_por' => $this->integer(11)->notNull()],
            $tableOptions);

        $this->createTable('{{%meta_financiera}}',
            [   'meta_financiera_id' => $this->primaryKey(),
                'descripcion' => $this->string(255),
                'avance_total' => $this->float(),
                'avance_actual' => $this->float()->defaultValue(0),
                'unidad_medida_id' => $this->integer(11)->notNull(),
                'precio_unitario_ro' => $this->float(8),
                'precio_unitario_rooc' => $this->float(8),
                'monto_total_ro' => $this->float(8),
                'monto_total_rooc' => $this->float(8),
                'presupuesto_cabecera_id' => $this->integer(11)->notNull(),
                'estado_regitro' => $this->integer(1)->defaultValue(1),
                'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'actualizado_por' => $this->integer(11)->notNull(),
                'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'creado_por' => $this->integer(11)->notNull()],
            $tableOptions);

        $this->createTable('{{%meta_fisica}}',
            [   'meta_fisica_id' => $this->primaryKey(),
                'descripcion' => $this->string(255),
                'avance_total' => $this->float(),
                'avance_actual' => $this->float()->defaultValue(0),
                'unidad_medida_id' => $this->integer(11)->notNull(),
                'presupuesto_cabecera_id' => $this->integer(11)->notNull(),
                'estado_regitro' => $this->integer(1)->defaultValue(1),
                'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'actualizado_por' => $this->integer(11)->notNull(),
                'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'creado_por' => $this->integer(11)->notNull()],
            $tableOptions);

        $this->createTable('{{%presupuesto_meta}}',
            [
                'presupuesto_meta_id' => $this->primaryKey(),
                'presupuesto_id' => $this->integer(11)->notNull(),
                'meta_fisica_id' => $this->integer(11)->notNull(),
                'meta_financiera_id' => $this->integer(11)->notNull(),
                'unidad_fisica_consumida_temp'     => $this->float(), /// aqui se detalla cuanto se esta consumiendo
                'unidad_financiera_consumida_temp' => $this->float(), /// aqui se detalla cuanto se esta consumiendo
                'unidad_fisica_consumida_final'     => $this->float(), /// aqui se detalla cuanto se esta consumiendo QUE SE EJECUTO
                'unidad_financiera_consumida_final' => $this->float(), /// aqui se detalla cuanto se esta consumiendo QUE SE EJECUTO
                'estado_meta'    => $this->integer(11)->notNull(), /// pediente/en espera(0),ejecutada(1), postergada(2)
                'estado_financiero' => $this->integer(), /// planificado(0), certificado(1), comprometido(2), devengado(3), girado(4),pagado(5),ejecutado(6)
                'estado_regitro' => $this->integer(1)->defaultValue(1),// 1 activo, 0 inactivo
                'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'actualizado_por' => $this->integer(11)->notNull(),
                'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'creado_por' => $this->integer(11)->notNull()],
            $tableOptions);


        $this->addForeignKey('codigo_meta_fk_usuario_creado', '{{%codigo_meta}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('codigo_meta_fk_usuario_actualizado', '{{%codigo_meta}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('usuario_actualizado_fk_codigo_meta', '{{%presupuesto_cabecera}}', 'codigo_meta_id', '{{%codigo_meta}}', 'codigo_meta_id');

        $this->addForeignKey('meta_financiera_fk_presupuesto_cabecera', '{{%meta_financiera}}', 'presupuesto_cabecera_id', '{{%presupuesto_cabecera}}', 'presupuesto_cabecera_id');
        $this->addForeignKey('meta_financiera_fk_usuario_creado', '{{%meta_financiera}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('meta_financiera_fk_usuario_actualizado', '{{%meta_financiera}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('meta_fisica_fk_presupuesto_cabecera', '{{%meta_fisica}}', 'presupuesto_cabecera_id', '{{%presupuesto_cabecera}}', 'presupuesto_cabecera_id');
        $this->addForeignKey('meta_fisica_fk_usuario_creado', '{{%meta_fisica}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('meta_fisica_fk_usuario_actualizado', '{{%meta_fisica}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('presupuesto_meta_fk_presupuesto', '{{%presupuesto_meta}}', 'presupuesto_id', '{{%presupuesto}}', 'presupuesto_id');
        $this->addForeignKey('presupuesto_meta_fk__usuario_creado', '{{%presupuesto_meta}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('presupuesto_meta_fk_usuario_actualizado', '{{%presupuesto_meta}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('presupuesto_meta_fk_meta_financiera', '{{%presupuesto_meta}}', 'meta_financiera_id', '{{%meta_financiera}}', 'meta_financiera_id');
        $this->addForeignKey('presupuesto_meta_fk_meta_fisica', '{{%presupuesto_meta}}', 'meta_fisica_id', '{{%meta_fisica}}', 'meta_fisica_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'presupuesto_meta_fk_presupuesto',
            'presupuesto_meta'
        );

        $this->dropForeignKey(
            'presupuesto_meta_fk__usuario_creado',
            'presupuesto_meta'
        );

        $this->dropForeignKey(
            'presupuesto_meta_fk_usuario_actualizado',
            'presupuesto_meta'
        );

        $this->dropForeignKey(
            'presupuesto_meta_fk_meta_financiera',
            'presupuesto_meta'
        );

        $this->dropForeignKey(
            'presupuesto_meta_fk_meta_fisica',
            'presupuesto_meta'
        );

        $this->dropForeignKey(
            'codigo_meta_fk_usuario_creado',
            'codigo_meta'
        );

        $this->dropForeignKey(
            'codigo_meta_fk_usuario_actualizado',
            'codigo_meta'
        );

        $this->dropForeignKey(
            'usuario_actualizado_fk_codigo_meta',
            'presupuesto_cabecera'
        );

        $this->dropForeignKey(
            'meta_financiera_fk_presupuesto_cabecera',
            'meta_financiera'
        );

        $this->dropForeignKey(
            'meta_fisica_fk_presupuesto_cabecera',
            'meta_fisica'
        );

        $this->dropForeignKey(
            'meta_financiera_fk_usuario_actualizado',
            'meta_financiera'
        );

        $this->dropForeignKey(
            'meta_financiera_fk_usuario_creado',
            'meta_financiera'
        );

        $this->dropForeignKey(
            'meta_fisica_fk_usuario_actualizado',
            'meta_fisica'
        );

        $this->dropForeignKey(
            'meta_fisica_fk_usuario_creado',
            'meta_fisica'
        );

        $this->dropTable('{{%codigo_meta}}');

        $this->dropTable('{{%meta_financiera}}');

        $this->dropTable('{{%meta_fisica}}');

        $this->dropTable('{{%presupuesto_meta}}');
    }
}