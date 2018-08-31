<?php

use yii\db\Migration;

class m180521_000014_create_unidad_de_medida extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%unidad_medida}}', [//contrato_carta_fianza
            'unidad_medida_id' => $this->primaryKey(),
            'unidad_medida_descripcion'    => $this->string(255),
            'estado_regitro' => $this->integer(1)->defaultValue(1),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
       
        $this->addForeignKey('unidad_medida_fk_usuario_creado', '{{%unidad_medida}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('unidad_medida_fk_usuario_actualizado', '{{%unidad_medida}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('meta_fisica_fk_unidad_medida', '{{%meta_fisica}}', 'unidad_medida_id', '{{%unidad_medida}}', 'unidad_medida_id');
        $this->addForeignKey('meta_financiera_fk_unidad_medida', '{{%meta_financiera}}', 'unidad_medida_id', '{{%unidad_medida}}', 'unidad_medida_id');
    }

    public function down()
    {

        $this->dropForeignKey(
            'meta_fisica_fk_unidad_medida',
            'meta_fisica'
        );

        $this->dropForeignKey(
            'meta_financiera_fk_unidad_medida',
            'meta_financiera'
        );

        $this->dropForeignKey(
            'unidad_medida_fk_usuario_creado',
            'unidad_medida'
        );

        $this->dropForeignKey(
            'unidad_medida_fk_usuario_actualizado',
            'unidad_medida'
        );
        
        $this->dropTable('{{%unidad_medida}}');
    }
}