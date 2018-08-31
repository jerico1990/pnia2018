<?php

use yii\db\Migration;

/**
 * Class m180517_180000_utilitario_ubigeo
 */
class m180517_000001_utilitario_ubigeo extends Migration
{
    public function up(){

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%utilitario_ubigeo}}', [
            'utilitario_ubigeo_id' => $this->string()->notNull(),//primaryKey(),
            'nombre' => $this->string(),
            'ubigeo_region_id'    => $this->string(),
            'ubigeo_provincia_id' => $this->string(),//integer(11),
            'actualizado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_en' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'creado_por' => $this->integer(11)->notNull(),
            'actualizado_por' => $this->integer(11)->notNull(),

        ], $tableOptions);
        
        $this->addPrimaryKey('ubigeo_provincia_PK', '{{%utilitario_ubigeo}}', ['utilitario_ubigeo_id']);

        $this->addForeignKey('ubigeo_fk_usuario_creado', '{{%utilitario_ubigeo}}', 'creado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('ubigeo_fk_usuario_actualizado', '{{%utilitario_ubigeo}}', 'actualizado_por', '{{%usuario}}', 'usuario_id');

        $this->addForeignKey('ubigeo_fk_ubigeo_region_id','{{utilitario_ubigeo}}','ubigeo_region_id','{{utilitario_ubigeo}}','utilitario_ubigeo_id');

        $this->addForeignKey('ubigeo_fk_ubigeo_provincia_id','{{utilitario_ubigeo}}','ubigeo_provincia_id','{{utilitario_ubigeo}}','utilitario_ubigeo_id');
    }

    public function down()
    {
        $this->dropForeignKey(
            'ubigeo_fk_usuario_creado',
            'utilitario_ubigeo'
        );

        $this->dropForeignKey(
            'ubigeo_fk_usuario_actualizado',
            'utilitario_ubigeo'
        );

        $this->dropForeignKey(
            'ubigeo_fk_ubigeo_region_id',
            'utilitario_ubigeo'
        );

        $this->dropForeignKey(
            'ubigeo_fk_ubigeo_provincia_id',
            'utilitario_ubigeo'
        );

        $this->dropTable('{{%utilitario_ubigeo}}');
        
    }


}
