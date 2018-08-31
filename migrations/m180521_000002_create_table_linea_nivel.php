<?php

use yii\db\Migration;

class m180521_000002_create_table_linea_nivel extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%linea_nivel}}', [//contrato_carta_fianza
            'linea_nivel_id' => $this->primaryKey(),
            'linea_id' => $this->integer(11)->notNull(),
            'nombre_linea'  => $this->string(),
            'numeracion'    => $this->string(),
            'nivel' => $this->integer(11)->notNull(),

            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->addForeignKey('linea_nivel_fk_linea', '{{%linea_nivel}}', 'linea_id', '{{%linea}}', 'linea_id');
        $this->addForeignKey('linea_nivel_fk_usuario_creado', '{{%linea_nivel}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('linea_nivel_fk_usuario_actualizado', '{{%linea_nivel}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {

        $this->dropForeignKey(
            'linea_nivel_fk_linea',
            'linea_nivel'
        );

        $this->dropForeignKey(
            'linea_nivel_fk_usuario_creado',
            'linea_nivel'
        );

        $this->dropForeignKey(
            'linea_nivel_fk_usuario_actualizado',
            'linea_nivel'
        );
        
        $this->dropTable('{{%linea_nivel}}');
    }
}
