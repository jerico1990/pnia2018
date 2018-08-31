<?php

use yii\db\Migration;

class m180419_150141_create_table_ubicacion extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ubicacion}}', [
            'ubicacion_id' => $this->primaryKey(),
            'ubicacion_padre_id' => $this->integer(11),
            'nombre' => $this->string()->notNull(),
            'codigo' => $this->string()->notNull(),
            'descripcion' => $this->string()->notNull(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('ubicacion_fk_ubicacion', '{{%ubicacion}}', 'ubicacion_padre_id', '{{%ubicacion}}', 'ubicacion_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('ubicacion_fk_usuario_creado', '{{%ubicacion}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('ubicacion_fk_usuario_actualizado', '{{%ubicacion}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
 
    }

    public function down()
    {
        $this->dropForeignKey(
            'ubicacion_fk_ubicacion',
            'ubicacion'
        );

        $this->dropForeignKey(
            'ubicacion_fk_usuario_creado',
            'ubicacion'
        );

        $this->dropForeignKey(
            'ubicacion_fk_usuario_actualizado',
            'ubicacion'
        );
        
        $this->dropTable('{{%ubicacion}}');
    }
}
