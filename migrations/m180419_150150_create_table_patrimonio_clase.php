<?php

use yii\db\Migration;

class m180419_150150_create_table_patrimonio_clase extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%patrimonio_clase}}', [
            'patrimonio_clase_id' => $this->primaryKey(),
            'patrimonio_clase_padre_id' => $this->integer(11),
            'nombre' => $this->string()->notNull(),
            'codigo' => $this->string()->notNull(),
            'tasa_depreciacion' => $this->double()->notNull(),  //cambiado de string a double
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('patrimonio_clase_fk_patrimonio', '{{%patrimonio_clase}}', 'patrimonio_clase_padre_id', '{{%patrimonio_clase}}', 'patrimonio_clase_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('patrimonio_clase_fk_usuario_creado', '{{%patrimonio_clase}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('patrimonio_clase_fk_usuario_actualizado', '{{%patrimonio_clase}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {

        $this->dropForeignKey(
            'patrimonio_clase_fk_patrimonio',
            'patrimonio_clase'
        );

        $this->dropForeignKey(
            'patrimonio_clase_fk_usuario_creado',
            'patrimonio_clase'
        );

        $this->dropForeignKey(
            'patrimonio_clase_fk_usuario_actualizado',
            'patrimonio_clase'
        );
        
        $this->dropTable('{{%patrimonio_clase}}');
    }
}
