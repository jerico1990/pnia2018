<?php

use yii\db\Migration;

class m180504_185829_create_table_pnia_entidad extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%pnia_entidad}}', [
            'pnia_entidad_id' => $this->primaryKey(),
            'tipo_entidad' => $this->integer(11),
            'ruc' => $this->bigInteger(),
            'razon_social' => $this->string(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('pnia_entidad_fk_metacodigo', '{{%pnia_entidad}}', 'tipo_entidad', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('pnia_entidad_fk_usuario_creado', '{{%pnia_entidad}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('pnia_entidad_fk_usuario_actualizado', '{{%pnia_entidad}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'pnia_entidad_fk_metacodigo',
            'pnia_entidad'
        );

        $this->dropForeignKey(
            'pnia_entidad_fk_usuario_creado',
            'pnia_entidad'
        );

        $this->dropForeignKey(
            'pnia_entidad_fk_usuario_actualizado',
            'pnia_entidad'
        );
        
        $this->dropTable('{{%pnia_entidad}}');
    }
}
