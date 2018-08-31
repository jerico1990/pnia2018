<?php

use yii\db\Migration;

class m180521_000004_create_table_presupuesto_version extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%presupuesto_version}}', [//contrato_carta_fianza
            'presupuesto_version_id' => $this->primaryKey(),
            'descripcion'   => $this->string(255),
            'detalle'       => $this->string(500),
            'nro_version'   => $this->integer(11)->notNull(),
            'fecha'         => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'estatus'       => $this->integer(1)->defaultValue(0), /// 0 inactivo, 1 activo, 2 en edición
            'actualizado_en'  => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en'     => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por'    => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->addForeignKey('presupuesto_version_fk_usuario_creado', '{{%presupuesto_version}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        
        $this->addForeignKey('presupuesto_version_fk_usuario_actualizado', '{{%presupuesto_version}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'presupuesto_version_fk_usuario_creado',
            'presupuesto_version'
        );

        $this->dropForeignKey(
            'presupuesto_version_fk_usuario_actualizado',
            'presupuesto_version'
        );

        $this->dropTable('{{%presupuesto_version}}');
    }
}