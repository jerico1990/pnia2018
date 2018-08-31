<?php

use yii\db\Migration;

class m180504_185814_create_table_staff_persona extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%staff_persona}}', [
            'staff_persona_id' => $this->primaryKey(),
            'dni' => $this->string(8)->notNull(),/// hacer una función de comparación que verifique que son solo números (numeric/number)
            'nombres' => $this->string(),
            'apellido_paterno' => $this->string(),
            'apellido_materno' => $this->string(),
            'codigo_pnia' => $this->string(),
            'ruc' => $this->string(11),
            'nivel' => $this->integer(2), // Nivel 1 vale más que nivel 10
            'staff_area_id' => $this->integer(11),
            'cuenta_bancaria' => $this->string(),
            'pnia_ent_financiera_id' => $this->integer(11)->null(),/// a la cual pertenece la cuenta de banco 
            // es sede?
            'cargo' => $this->string(),
            'fecha_nacimiento' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'poliza_seguro' => $this->string(),
            'email' => $this->string(),
            
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('staff_persona_fk_pnia_ent_financiera_id','{{%staff_persona}}','pnia_ent_financiera_id','{{%pnia_ent_financiera}}' , 'pnia_ent_financiera_id' );
        
        $this->addForeignKey('staff_persona_fk_usuario_creado', '{{%staff_persona}}', 'creado_por', '{{%usuario}}', 'usuario_id');
        
        $this->addForeignKey('staff_persona_fk_usuario_actualizado', '{{%staff_persona}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
        
        /// agregando persona a usuario
        $this->addForeignKey('usuario_fk_staff_persona', '{{%usuario}}', 'persona_id', '{{%staff_persona}}', 'staff_persona_id');

    }

    public function down()
    {

        $this->dropForeignKey(
            'staff_persona_fk_pnia_ent_financiera_id',
            'staff_persona'
        );

        $this->dropForeignKey(
            'staff_persona_fk_usuario_creado',
            'staff_persona'
        );

        $this->dropForeignKey(
            'staff_persona_fk_usuario_actualizado',
            'staff_persona'
        );

        $this->dropForeignKey(
            'usuario_fk_staff_persona',
            'usuario'
        );

        $this->dropTable('{{%staff_persona}}');
    }
}
