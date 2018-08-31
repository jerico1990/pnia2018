<?php

use yii\db\Migration;

class m180611_000001_create_arbol_area extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%arbol_area}}', [
            'arbol_area_id' => $this->primaryKey(),

            'staff_area_id' => $this->integer(11)->notNull(),
            'presupuesto_cabecera_id' => $this->integer(11)->notNull(),
            'presupuesto_cabecera_nombre' => $this->string(),
            
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);
        
        $this->addForeignKey('arbol_area_fk_staff_area','{{%arbol_area}}','staff_area_id','{{%staff_area}}','staff_area_id');
        
        $this->addForeignKey('arbol_area_fk_presupuesto_cabecera','{{%arbol_area}}','presupuesto_cabecera_id','{{%presupuesto_cabecera}}','presupuesto_cabecera_id');
        
        $this->addForeignKey('arbol_area_fk_usuario_creado', '{{%arbol_area}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        $this->addForeignKey('arbol_area_fk_usuario_actualizado', '{{%arbol_area}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'arbol_area_fk_staff_area',
            'arbol_area'
        );

        $this->dropForeignKey(
            'arbol_area_fk_presupuesto_cabecera',
            'arbol_area'
        );

        $this->dropForeignKey(
            'arbol_area_fk_usuario_creado',
            'arbol_area'
        );

        $this->dropForeignKey(
            'arbol_area_fk_usuario_actualizado',
            'arbol_area'
        );
        
        $this->dropTable('{{%arbol_area}}');
    }
}