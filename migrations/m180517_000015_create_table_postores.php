<?php

use yii\db\Migration;

class m180517_000015_create_table_postores extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%postores}}', [
            'postores_id' => $this->primaryKey(),
            'adjudicacion_id' => $this->integer(11),//fk adjudicacion
            'dni' => $this->string(8)->notNull(),/// hacer una función de comparación que verifique que son solo números (numeric/number)
            'nombres' => $this->string(),
            'apellido_paterno' => $this->string(),
            'apellido_materno' => $this->string(),
            'ruc' => $this->string(11),
            'fecha_nacimiento' => $this->timestamp(),
            'email' => $this->string(),
            'telefono' => $this->string(),
            'situacion_postor_id' => $this->integer(11), // situacion del postor pendiente, aprobado, desaprobado
            'actualizado_en' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11),
            'creado_en' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11),
        ], $tableOptions);

        $this->addForeignKey('postores_fk_usuario_creado', '{{%postores}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('postores_fk_usuario_actualizado', '{{%postores}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');


    }

    public function down()
    {

        $this->dropForeignKey(
            'postores_fk_usuario_creado',
            'postores'
        );

        $this->dropForeignKey(
            'postores_fk_usuario_actualizado',
            'postores'
        );

        $this->dropTable('{{%postores}}');
    }
}
