<?php

use yii\db\Migration;

/**
 * Class m180825_035249_table_requerimiento
 */
class m180825_035249_table_requerimiento extends Migration
{
    /**
     * {@inheritdoc}
     */
     public function up()
     {
         $tableOptions = null;
         if ($this->db->driverName === 'mysql') {
             $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
         }

         $this->createTable('{{%requerimiento}}', [
             'requerimiento_id' => $this->primaryKey(),
             'tipo_requerimiento_id' => $this->integer(11)->notNull(),
             'descripcion' => $this->string(5000),
             'asunto' => $this->string(250),
             'documento' => $this->string(150),
             'estado_registro_id' => $this->integer(),
             'situacion_requerimiento_id' => $this->integer(),
             'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
             'actualizado_por' => $this->integer(11)->notNull(),
             'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
             'creado_por' => $this->integer(11)->notNull()
         ], $tableOptions);

         $this->addForeignKey('requerimiento_fk_metacodigo','{{%requerimiento}}','tipo_requerimiento_id','{{%metacodigo}}','metacodigo_id');

     }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180825_035249_table_requerimiento cannot be reverted.\n";

        return false;
    }
    */
}
