<?php

use yii\db\Migration;

class m180419_150158_create_table_metacodigo extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%metacodigo}}', [
            'metacodigo_id' => $this->primaryKey(),
            'nombre_lista' => $this->string(),
            'codigo' => $this->integer(5),
            'descripcion' => $this->string(),
            'descripcion2' => $this->string(), //??
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('metacodigo_fk_usuario_creado', '{{%metacodigo}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        
        $this->addForeignKey('metacodigo_fk_usuario_actualizado', '{{%metacodigo}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'metacodigo_fk_usuario_creado',
            'metacodigo'
        );

        $this->dropForeignKey(
            'metacodigo_fk_usuario_actualizado',
            'metacodigo'
        );
        
        $this->dropTable('{{%metacodigo}}');
    }
}
