<?php

use yii\db\Migration;

class m180517_000007_create_table_fondo_viatico_detalle extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%fondo_viatico_detalle}}', [//contrato_carta_fianza
            'fondo_viatico_detalle_id' => $this->primaryKey(),
            'fondo_fondo_id' =>  $this->integer(11)->notNull(),
            'destino_inicial_ubigeo' => $this->string(),//integer(11)->notNull(),
            'destino_final_ubigeo' => $this->string(),//integer(11)->notNull(),
            'numero_dias' => $this->integer(11)->notNull(),
            'monto' => $this->float()->notNull(),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'actualizado_por' => $this->integer(11)->notNull(),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->addForeignKey('fondo_viatico_detalle_fk_destino_inicial_ubigeo', '{{%fondo_viatico_detalle}}', 'destino_inicial_ubigeo', '{{%utilitario_ubigeo}}', 'utilitario_ubigeo_id');

        $this->addForeignKey('fondo_viatico_detalle_fk_destino_final_ubigeo', '{{%fondo_viatico_detalle}}', 'destino_final_ubigeo', '{{%utilitario_ubigeo}}', 'utilitario_ubigeo_id');

        $this->addForeignKey('fondo_viatico_detalle_fk_fondo_fondo', '{{%fondo_viatico_detalle}}', 'fondo_fondo_id', '{{%fondo_fondo}}', 'fondo_fondo_id');
  
        $this->addForeignKey('fondo_viatico_detalle_fk_usuario_creado', '{{%fondo_viatico_detalle}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('fondo_viatico_detalle_fk_usuario_actualizado', '{{%fondo_viatico_detalle}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'fondo_viatico_detalle_fk_destino_inicial_ubigeo',
            'fondo_viatico_detalle'
        );

        $this->dropForeignKey(
            'fondo_viatico_detalle_fk_destino_final_ubigeo',
            'fondo_viatico_detalle'
        );

        $this->dropForeignKey(
            'fondo_viatico_detalle_fk_usuario_creado',
            'fondo_viatico_detalle'
        );

        $this->dropForeignKey(
            'fondo_viatico_detalle_fk_usuario_actualizado',
            'fondo_viatico_detalle'
        );

        $this->dropForeignKey(
            'fondo_viatico_detalle_fk_fondo_fondo',
            'fondo_viatico_detalle'
        );
        
        $this->dropTable('{{%fondo_viatico_detalle}}');
    }
}
