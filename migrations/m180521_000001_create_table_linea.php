<?php

use yii\db\Migration;

class m180521_000001_create_table_linea extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%linea}}', [//contrato_carta_fianza
            'linea_id' => $this->primaryKey(),
            'titulo' => $this->string(),
            'numeracion' => $this->string(),
            //'linea_nivel_id' => $this->integer(11)->notNull(),

            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
        //$this->addForeignKey('linea_fk_linea_nivel', '{{%linea}}', 'linea_nivel_id', '{{%linea_nivel}}', 'linea_nivel_id');


        $this->addForeignKey('linea_fk_usuario_creado', '{{%linea}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('linea_fk_usuario_actualizado', '{{%linea}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        /*
        $this->dropForeignKey(
            'linea_fk_linea_nivel',
            'linea'
        ); // */

        $this->dropForeignKey(
            'linea_fk_usuario_creado',
            'linea'
        );

        $this->dropForeignKey(
            'linea_fk_usuario_actualizado',
            'linea'
        );

        $this->dropTable('{{%linea}}');
    }
}