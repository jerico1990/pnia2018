

<?php

use yii\db\Migration;

class m180521_000006_create_table_presupuesto_cabecera extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%presupuesto_cabecera}}', [//contrato_carta_fianza
            /// --- campos propios
            'presupuesto_cabecera_id' => $this->primaryKey(),
            'presupuesto_cabecera_padre_id' => $this->integer(11), //recursiva a un padre
            'presupuesto_cabecera_id_original' => $this->integer(11), //recursiva al presupuesto original, en su primer caso a si mismos
            'jerarquia' => $this->integer(11)->notNull()->defaultValue(1), // 0 Raiz, 1 Rama , 2 hoja, Otherwise Error
            'tipo_presupuesto' => $this->integer(1)->notNull()->defaultValue(1), // pip1(1),pip2(2),pip3(3)
            /// --- Linea
            'indice_linea'  => $this->integer(11)->notNull(),

            /// --- Campos de Linea-Nivel
            'nombre_linea'  => $this->string(),
            'numeracion_linea'    => $this->string(),
            'nivel' => $this->integer(11)->notNull(),

            /// fks
            'presupuesto_version_id' => $this->integer(11)->notNull(),
            //'linea_nivel_id' => $this->integer(11)->notNull(),

            /// --- Campos Condicionados por su Nivel ---
                /// Nivel 1
                    'objetivo_estrategico_id' => $this->integer(11),
                    'accion_estrategica_id'   => $this->integer(11),
                /// Nivel 2
                    'presupuesto_contrato_id' => $this->integer(11),
                /// Nivel 5
                    'codigo_meta_id'    => $this->integer(11),
                    'categoria_producto_id' => $this->integer(11),
                /// Nivel 6
                    'partida_id' => $this->integer(11),//->notNull(),
                    //'meta_fisica_id'   => $this->integer(11),
                    //'meta_financiera_id'   => $this->integer(11),

            /// --- data de control ---
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),

        ], $tableOptions);

        $this->createIndex('presupuesto_cabecera_index_indice_linea','{{presupuesto_cabecera}}','indice_linea');//esto terminarlo

        $this->addForeignKey('presupuesto_cabecera_fk_presupuesto_version', '{{%presupuesto_cabecera}}', 'presupuesto_version_id', '{{%presupuesto_version}}', 'presupuesto_version_id');

        //$this->addForeignKey('presupuesto_cabecera_fk_linea_nivel', '{{%presupuesto_cabecera}}', 'linea_nivel_id', '{{%linea_nivel}}', 'linea_nivel_id');

        $this->addForeignKey('presupuesto_cabecera_fk_partida', '{{%presupuesto_cabecera}}', 'partida_id', '{{%partida}}', 'partida_id');

        $this->addForeignKey('presupuesto_cabecera_fk_presupuesto_cabecera', '{{%presupuesto_cabecera}}', 'presupuesto_cabecera_padre_id', '{{%presupuesto_cabecera}}', 'presupuesto_cabecera_id');

        $this->addForeignKey('presupuesto_cabecera_fk_usuario_creado', '{{%presupuesto_cabecera}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('presupuesto_cabecera_fk_usuario_actualizado', '{{%presupuesto_cabecera}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('flujo_requerimiento_fk_presupuesto_cabecera', '{{%flujo_requerimiento}}', 'codigo_arbol', '{{%presupuesto_cabecera}}', 'presupuesto_cabecera_id');

        $this->createTable('{{%presupuesto_cabecera_rol}}', [

            'presupuesto_cabecera_rol_id' => $this->primaryKey(),
            'presupuesto_cabecera_id' => $this->integer(11),
            'rol_id' => $this->integer(11),
            /// --- data de control ---
            'estado_registro'=> $this->boolean(), // 1 activo, 0 inactivo
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('presupuesto_cabecera_rol_fk_usuario_creado', '{{%presupuesto_cabecera_rol}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('presupuesto_cabecera_rol_fk_usuario_actualizado', '{{%presupuesto_cabecera_rol}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('presupuesto_cabecera_rol_fk_rol', '{{%presupuesto_cabecera_rol}}', 'presupuesto_cabecera_id', '{{%presupuesto_cabecera}}', 'presupuesto_cabecera_id');

        $this->addForeignKey('presupuesto_cabecera_rol_fk_presupuesto_cabecera', '{{%presupuesto_cabecera_rol}}', 'rol_id', '{{%rol}}', 'rol_id');

    }

    public function down()
    {
        /// presupuesto_cabecera_rol
        $this->dropForeignKey(
            'presupuesto_cabecera_rol_fk_usuario_creado',
            'presupuesto_cabecera_rol'
        );

        $this->dropForeignKey(
            'presupuesto_cabecera_rol_fk_usuario_actualizado',
            'presupuesto_cabecera_rol'
        );

        $this->dropForeignKey(
            'presupuesto_cabecera_rol_fk_rol',
            'presupuesto_cabecera_rol'
        );

        $this->dropForeignKey(
            'presupuesto_cabecera_rol_fk_presupuesto_cabecera',
            'presupuesto_cabecera_rol'
        );

        $this->dropTable('{{%presupuesto_cabecera_rol}}');

        /////de flujo_requerimiento/////
        $this->dropForeignKey(
            'flujo_requerimiento_fk_presupuesto_cabecera',
            'flujo_requerimiento'
        );

        $this->dropIndex(
            'presupuesto_cabecera_index_indice_linea',
            'presupuesto_cabecera'
        );

        $this->dropForeignKey(
            'presupuesto_cabecera_fk_presupuesto_version',
            'presupuesto_cabecera'
        );

        $this->dropForeignKey(
            'presupuesto_cabecera_fk_partida',
            'presupuesto_cabecera'
        );

        $this->dropForeignKey(
            'presupuesto_cabecera_fk_presupuesto_cabecera',
            'presupuesto_cabecera'
        );

        $this->dropForeignKey(
            'presupuesto_cabecera_fk_usuario_creado',
            'presupuesto_cabecera'
        );

        $this->dropForeignKey(
            'presupuesto_cabecera_fk_usuario_actualizado',
            'presupuesto_cabecera'
        );

        $this->dropTable('{{%presupuesto_cabecera}}');
    }
}