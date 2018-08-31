<?php

use yii\db\Migration;

class m180521_000015_categoria_producto extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%categoria_producto}}', [//contrato_carta_fianza
            'categoria_producto_id' => $this->primaryKey(),
            'categoria_producto_descripcion'    => $this->string(255),
            'es_categoria'   => $this->integer(1)->defaultValue(1),
            'estado_regitro' => $this->integer(1)->defaultValue(1),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
       
        $this->addForeignKey('categoria_producto_fk_usuario_creado', '{{%categoria_producto}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('categoria_producto_fk_usuario_actualizado', '{{%categoria_producto}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('presupuesto_cabecera_fk_categoria_producto', '{{%presupuesto_cabecera}}', 'categoria_producto_id', '{{%categoria_producto}}', 'categoria_producto_id');
    }

    public function down()
    {

        $this->dropForeignKey(
            'presupuesto_cabecera_fk_categoria_producto',
            'presupuesto_cabecera'
        );

        $this->dropForeignKey(
            'categoria_producto_fk_usuario_actualizado',
            'categoria_producto'
        );

        $this->dropForeignKey(
            'categoria_producto_fk_usuario_creado',
            'categoria_producto'
        );
        
        $this->dropTable('{{%categoria_producto}}');
    }
}