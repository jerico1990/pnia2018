<?php

use yii\db\Migration;

class m180419_150135_create_table_documento_pnia extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%documento_pnia}}', [
            'documento_pnia_id' => $this->primaryKey(),
            'tabla' => $this->string(),
            'pk_tabla'=> $this->integer(11),
            'ruta_documento' => $this->string(),
            'nombre_documento' => $this->string(),
            'documento' => $this->string(),
            'documento_mimetype' => $this->string(),
            'documento_charset' => $this->string(),
            'documento_lastupd' => $this->timestamp(),
            //'logistica_proceso_id' => $this->integer(11)->notNull(),
            //'flujo_requerimiento_id' => $this->integer(11),

            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('documento_pnia_fk_usuario_creado', '{{%documento_pnia}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('documento_pnia_fk_usuario_actualizado', '{{%documento_pnia}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');

    }

    public function down()
    {
        $this->dropForeignKey(
            'documento_pnia_fk_usuario_creado',
            'documento_pnia'
        );

        $this->dropForeignKey(
            'documento_pnia_fk_usuario_actualizado',
            'documento_pnia'
        );

        $this->dropTable('{{%documento_pnia}}');
    }
}
