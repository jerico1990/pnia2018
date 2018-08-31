<?php

use yii\db\Migration;

/**
 * Class m180826_043546_table_adjudicacion
 */
class m180826_043546_table_adjudicacion extends Migration
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

         $this->createTable('{{%adjudicacion}}', [
             'adjudicacion_id' => $this->primaryKey(),
             'requerimiento_detalle_id' => $this->integer(11)->notNull(),
             'requerimiento_id' => $this->integer(11)->notNull(),
             'situacion_adjudicacion_id' => $this->integer(),

             'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
             'actualizado_por' => $this->integer(11)->notNull(),
             'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
             'creado_por' => $this->integer(11)->notNull()
         ], $tableOptions);

         //$this->addForeignKey('requerimiento_detalle_id_fk_adjudicacion','{{%requerimiento_detalle}}','requerimiento_detalle_id','{{%adjudicacion}}','requerimiento_detalle_id');

     }

    /**
     * {@inheritdoc}
     */


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180826_043546_table_adjudicacion cannot be reverted.\n";

        return false;
    }
    */
}
