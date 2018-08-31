<?php

use yii\db\Migration;

class m180419_150209_create_table_patrimonio_item extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%patrimonio_item}}', [
            'patrimonio_item_id' => $this->primaryKey(),
            'patrimonio_clase_id' => $this->integer(11),
            'metacodigo_id' => $this->integer(11),
            'documento_pnia_id' => $this->integer(11),
            'codigo' => $this->string(),
            'descripcion' => $this->string(),
            'fecha_alta' => $this->timestamp(),
            'fecha_baja' => $this->timestamp(),
            'valor_historico' => $this->double(),
            'marca' => $this->string(),
            'modelo' => $this->string(),
            'serie' => $this->string(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('patrimonio_item_fk_patrimonio_clase', '{{%patrimonio_item}}', 'patrimonio_clase_id', '{{%patrimonio_clase}}', 'patrimonio_clase_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('patrimonio_item_fk_metacodigo', '{{%patrimonio_item}}', 'metacodigo_id', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('patrimonio_item_fk_documento_pnia', '{{%patrimonio_item}}', 'documento_pnia_id', '{{%documento_pnia}}', 'documento_pnia_id', 'NO ACTION', 'NO ACTION');
        
        $this->addForeignKey('patrimonio_item_fk_usuario_creado', '{{%patrimonio_item}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('patrimonio_item_fk_usuario_actualizado', '{{%patrimonio_item}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'patrimonio_item_fk_patrimonio_clase',
            'patrimonio_item'
        );

        $this->dropForeignKey(
            'patrimonio_item_fk_metacodigo',
            'patrimonio_item'
        );

        $this->dropForeignKey(
            'patrimonio_item_fk_documento_pnia',
            'patrimonio_item'
        );

        $this->dropForeignKey(
            'patrimonio_item_fk_usuario_creado',
            'patrimonio_item'
        );   
        
        $this->dropForeignKey(
            'patrimonio_item_fk_usuario_actualizado',
            'patrimonio_item'
        ); 
        
        $this->dropTable('{{%patrimonio_item}}');
    }
}
