<?php

use yii\db\Migration;

class m180517_000004_create_table_flujo_paso extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%flujo_paso}}', [
            'flujo_paso_id' => $this->primaryKey(),
            'flujo' => $this->integer(11), //fk a flujo_flujo
            'nombre_paso' => $this->string(), 
            'estado_paso_metacodigo' => $this->integer(11),

            'area_responsable_id' => $this->integer(11),
            
            'primer_flujo_paso' => $this->integer(11),
            'nivel' => $this->integer(),
            'cantidad_dias' => $this->integer(),
            'proceso_presupuesto' => $this->string(),
            
            'nivel_siguiente' => $this->integer(),

            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);


        $this->addForeignKey('flujo_paso_fk_flujo_paso', '{{%flujo_paso}}', 'primer_flujo_paso', '{{%flujo_paso}}', 'flujo_paso_id');

        $this->addForeignKey('flujo_paso_fk_flujo_flujo', '{{%flujo_paso}}', 'flujo', '{{%flujo_flujo}}', 'flujo_flujo_id');

        $this->addForeignKey('flujo_paso_fk_estado_paso_metacodigo', '{{%flujo_paso}}', 'estado_paso_metacodigo', '{{%metacodigo}}', 'metacodigo_id');

        $this->addForeignKey('flujo_paso_fk_staff_area', '{{%flujo_paso}}', 'area_responsable_id', '{{%staff_area}}', 'staff_area_id');

        $this->addForeignKey('flujo_paso_fk_usuario_creado', '{{%flujo_paso}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('flujo_paso_fk_usuario_actualizado', '{{%flujo_paso}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
        
    }

    public function down()
    {
        $this->dropForeignKey(
            'flujo_paso_fk_flujo_paso',
            'flujo_paso'
        );

        $this->dropForeignKey(
            'flujo_paso_fk_flujo_flujo',
            'flujo_paso'
        );

        $this->dropForeignKey(
            'flujo_paso_fk_estado_paso_metacodigo',
            'flujo_paso'
        );

        $this->dropForeignKey(
            'flujo_paso_fk_staff_area',
            'flujo_paso'
        );

        $this->dropForeignKey(
            'flujo_paso_fk_usuario_creado',
            'flujo_paso'
        );
        
        $this->dropForeignKey(
            'flujo_paso_fk_usuario_actualizado',
            'flujo_paso'
        );
        $this->dropTable('{{%flujo_paso}}');
    }
}
