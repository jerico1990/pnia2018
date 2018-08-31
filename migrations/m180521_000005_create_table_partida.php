<?php

use yii\db\Migration;

class m180521_000005_create_table_partida extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%partida}}', [//contrato_carta_fianza
            'partida_id' => $this->primaryKey(),
            'numero' => $this->string(),
            'descripcion' => $this->string(),

            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->addForeignKey('partida_fk_usuario_creado', '{{%partida}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('partida_fk_usuario_actualizado', '{{%partida}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'partida_fk_usuario_creado',
            'partida'
        );

        $this->dropForeignKey(
            'partida_fk_usuario_actualizado',
            'partida'
        );

        $this->dropTable('{{%partida}}');
    }
}