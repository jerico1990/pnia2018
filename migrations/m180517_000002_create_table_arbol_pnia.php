<?php

use yii\db\Migration;

class m180517_000002_create_table_arbol_pnia extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%arbol_pnia}}', [
            'arbol_pnia_id' => $this->primaryKey(),
            'descripcion' => $this->string(),

            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        
        $this->addForeignKey('arbol_pnia_fk_usuario_creado', '{{%arbol_pnia}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        
        $this->addForeignKey('arbol_pnia_fk_usuario_actualizado', '{{%arbol_pnia}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'arbol_pnia_fk_usuario_creado',
            'arbol_pnia'
        );

        $this->dropForeignKey(
            'arbol_pnia_fk_usuario_actualizado',
            'arbol_pnia'
        );

        $this->dropTable('{{%arbol_pnia}}');
    }
}
