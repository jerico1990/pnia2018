<?php

use yii\db\Migration;

class m180517_000003_create_table_flujo_flujo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%flujo_flujo}}', [
            'flujo_flujo_id' => $this->primaryKey(),
            'nombre_flujo' => $this->string(),
            'tipo_flujo_metacodigo' => $this->integer(11), //fk de flujo_requerimiento
            
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);


        $this->addForeignKey('flujo_flujo_fk_tipo_flujo_metacodigo', '{{%flujo_flujo}}', 'tipo_flujo_metacodigo', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('flujo_flujo_fk_usuario_creado', '{{%flujo_flujo}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        
        $this->addForeignKey('flujo_flujo_fk_usuario_actualizado', '{{%flujo_flujo}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'flujo_flujo_fk_tipo_flujo_metacodigo',
            'flujo_flujo'
        );

        $this->dropForeignKey(
            'flujo_flujo_fk_usuario_creado',
            'flujo_flujo'
        );

        $this->dropForeignKey(
            'flujo_flujo_fk_usuario_actualizado',
            'flujo_flujo'
        );
        $this->dropTable('{{%flujo_flujo}}');
    }
}
