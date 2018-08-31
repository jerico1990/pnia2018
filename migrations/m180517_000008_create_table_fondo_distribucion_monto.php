<?php

use yii\db\Migration;

class m180517_000008_create_table_fondo_distribucion_monto extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%fondo_distribucion_monto}}', [
            'fondo_distribucion_monto_id' => $this->primaryKey(),
            'escala_metacodigo' => $this->integer(11),
            'concepto_metacodigo' => $this->integer(11),
            'destino_ini_ubigeo' => $this->string(),//integer(11),
            'destino_fin_ubigeo' => $this->string(),//integer(11),
            'monto_determinado' => $this->float(),
            
        
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fondo_distribucion_monto_fk_concepto_metacodigo', '{{%fondo_distribucion_monto}}', 'concepto_metacodigo', '{{%metacodigo}}', 'metacodigo_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('fondo_distribucion_monto_fk_destino_ini_ubigeo', '{{%fondo_distribucion_monto}}', 'destino_ini_ubigeo', '{{%utilitario_ubigeo}}', 'utilitario_ubigeo_id', 'NO ACTION', 'NO ACTION');

        $this->addForeignKey('fondo_distribucion_monto_fk_destino_fin_ubigeo', '{{%fondo_distribucion_monto}}', 'destino_fin_ubigeo', '{{%utilitario_ubigeo}}', 'utilitario_ubigeo_id', 'NO ACTION', 'NO ACTION');
        
         $this->addForeignKey('fondo_distribucion_monto_fk_usuario_creado', '{{%fondo_distribucion_monto}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('fondo_distribucion_monto_fk_usuario_actualizado', '{{%fondo_distribucion_monto}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        // $this->dropForeignKey(
        //     'fondo_distribucion_monto_fk_escala_metacodigo',
        //     'fondo_distribucion_monto'
        // );

        $this->dropForeignKey(
            'fondo_distribucion_monto_fk_concepto_metacodigo',
            'fondo_distribucion_monto'
        );
        
        $this->dropForeignKey(
            'fondo_distribucion_monto_fk_destino_ini_ubigeo',
            'fondo_distribucion_monto'
        );
        
        $this->dropForeignKey(
            'fondo_distribucion_monto_fk_destino_fin_ubigeo',
            'fondo_distribucion_monto'
        );
        
        $this->dropForeignKey(
            'fondo_distribucion_monto_fk_usuario_creado',
            'fondo_distribucion_monto'
        );

        $this->dropForeignKey(
            'fondo_distribucion_monto_fk_usuario_actualizado',
            'fondo_distribucion_monto'
        );

        $this->dropTable('{{%fondo_distribucion_monto}}');
    }
}
