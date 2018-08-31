<?php

use yii\db\Migration;

/**
 * Class m180319_180006_tabla_mensaje
 */
class m180319_180007_tabla_mensaje extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%mensaje}}', [
            'mensaje_id' => $this->primaryKey(),
            
            'titulo' => $this->string(200),
            'mensaje' => $this->text(),

            'usuario_id_de' => $this->integer(11)->notNull(),
            'usuario_id_para' => $this->integer(11),//->notNull(),

            'status' => $this->string(30)->notNull(),// enviado,leido
            //'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            //'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            //'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        //$this->addForeignKey('mensaje_fk_usuario_creado', '{{%mensaje}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('mensaje_fk_usuario_de', '{{%mensaje}}', 'usuario_id_de', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('mensaje_fk_usuario_para', '{{%mensaje}}', 'usuario_id_para', '{{%usuario}}', 'usuario_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'mensaje_fk_usuario_de',
            'mensaje'
        );

        $this->dropForeignKey(
            'mensaje_fk_usuario_para',
            'mensaje'
        );

        $this->dropTable('{{%mensaje}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180319_184813_tabla_rol cannot be reverted.\n";

        return false;
    }
    */
}
