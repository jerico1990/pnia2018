<?php

use yii\db\Migration;

class m180504_185819_create_table_staff_area extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%staff_area}}', [
            'staff_area_id' => $this->primaryKey(),
            'codigo' => $this->string(),
            'descripcion' => $this->string(),
            'cargo' => $this->string(),
            'responsable' => $this->integer(11),
            'area_superior' => $this->integer(11),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);
        
        $this->addForeignKey('staff_area_fk_staff_persona', '{{%staff_area}}', 'responsable', '{{%staff_persona}}', 'staff_persona_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('staff_area__fk_staff_area', '{{%staff_area}}', 'area_superior', '{{%staff_area}}', 'staff_area_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('staff_area_fk_usuario_creado', '{{%staff_area}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        
        $this->addForeignKey('staff_area_fk_usuario_actualizado', '{{%staff_area}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
        /// Agregando vinculo de pertenencia de persona a un area
        $this->addForeignKey('staff_persona_fk_staff_area', '{{%staff_persona}}', 'staff_area_id', '{{%staff_area}}', 'staff_area_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'staff_persona_fk_staff_area',
            'staff_persona'
        );        

        $this->dropForeignKey(
            'staff_area_fk_staff_persona',
            'staff_area'
        );

        $this->dropForeignKey(
            'staff_area__fk_staff_area',
            'staff_area'
        );

        $this->dropForeignKey(
            'staff_area_fk_usuario_creado',
            'staff_area'
        );

        $this->dropForeignKey(
            'staff_area_fk_usuario_actualizado',
            'staff_area'
        );

        $this->dropTable('{{%staff_area}}');
    }
}
