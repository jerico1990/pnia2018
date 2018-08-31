<?php

use yii\db\Migration;

class m180504_185813_create_table_pnia_ent_financiera extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%pnia_ent_financiera}}', [
            'pnia_ent_financiera_id' => $this->primaryKey(),
            'tipo_entidad' => $this->integer(11),
            'razon_social' => $this->string(),
            'cuenta_bancaria' => $this->string(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('pnia_ent_financiera_fk_metacodigo', '{{%pnia_ent_financiera}}', 'tipo_entidad', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('pnia_ent_financiera_fk_usuario_creado', '{{%pnia_ent_financiera}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('pnia_ent_financiera_fk_usuario_actualizado', '{{%pnia_ent_financiera}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'pnia_ent_financiera_fk_metacodigo',
            'pnia_ent_financiera'
        );

        $this->dropForeignKey(
            'pnia_ent_financiera_fk_usuario_creado',
            'pnia_ent_financiera'
        );

        $this->dropForeignKey(
            'pnia_ent_financiera_fk_usuario_actualizado',
            'pnia_ent_financiera'
        );
        
        $this->dropTable('{{%pnia_ent_financiera}}');
    }
}
