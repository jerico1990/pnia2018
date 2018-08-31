<?php

use yii\db\Migration;

/**
 * Class m180319_180000_tabla_usuario
 */
class m181215_160000_Inserts extends Migration
{
    public function up(){
        $this->insert('usuario',array(
            'alias' => 'master',
            'clave_autenticacion' => 'non',
            'password_hash' => '$2y$13$M/gOwqCl8CQwsbU9Q1vTbeEVGTe62b7Oe1jvVUw1BLu3JF7QSr9Ce',
                //('MiPassword1'),
            'token_de_acceso' => 'AccToken',
        ));

/////// PERIODO 0 - Presupuestos ////////////
        $this->insert('periodo',[
            'anho' => 0,
            'trimestre' => 0,
            'mes' => 0 ,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ]); //General/gestion-adquisicion(Logística)
            //General/tramite-documentario(Trámite documentario)

////////METACÓGIDOS////////
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Movimiento',
            'codigo'            => 1,
            'descripcion'       => 'Traslado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Movimiento',
            'codigo'            => 2,
            'descripcion'       => 'Entrega',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Sexo',
            'codigo'            => 1,
            'descripcion'       => 'Masculino',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Sexo',
            'codigo'            => 2,
            'descripcion'       => 'Femenino',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Condición',
            'codigo'            => 1,
            'descripcion'       => 'Optima',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Condición',
            'codigo'            => 2,
            'descripcion'       => 'Deprecado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado',
            'codigo'            => 1,
            'descripcion'       => 'Encontrado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado',
            'codigo'            => 2,
            'descripcion'       => 'No habido',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Entidad',
            'codigo'            => 1,
            'descripcion'       => 'Estatal',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Entidad',
            'codigo'            => 2,
            'descripcion'       => 'Privado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Entidad',
            'codigo'            => 3,
            'descripcion'       => 'ONG',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Entidad_Financiera',
            'codigo'            => 1,
            'descripcion'       => 'Caja de Ahorros',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Entidad_Financiera',
            'codigo'            => 2,
            'descripcion'       => 'Caja Municipal',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Entidad_Financiera',
            'codigo'            => 3,
            'descripcion'       => 'Banca Privada',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_de_Entregable',
            'codigo'            => 1,
            'descripcion'       => 'Entregado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_de_Entregable',
            'codigo'            => 2,
            'descripcion'       => 'En Transito',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Concepto_Distribucion',
            'codigo'            => 1,
            'descripcion'       => 'Alimentacion',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Concepto_Distribucion',
            'codigo'            => 2,
            'descripcion'       => 'Transporte',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Concepto_Distribucion',
            'codigo'            => 3,
            'descripcion'       => 'Hospedaje',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Concepto_Distribucion',
            'codigo'            => 4,
            'descripcion'       => 'Declaracion Jurada',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Escala_Distribucion',
            'codigo'            => 1,
            'descripcion'       => 'Nivel 1',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Escala_Distribucion',
            'codigo'            => 2,
            'descripcion'       => 'Nivel 2',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_flujo',
            'codigo'            => 1,
            'descripcion'       => 'Viático',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_flujo',
            'codigo'            => 2,
            'descripcion'       => 'Rendición',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_flujo',
            'codigo'            => 3,
            'descripcion'       => 'Caja Chica',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_flujo',
            'codigo'            => 4,
            'descripcion'       => 'Entrega',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_flujo',
            'codigo'            => 5,
            'descripcion'       => 'Desembolso',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));


        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_Presupuesto',
            'codigo'            => 1,
            'descripcion'       => 'En Planificación',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_Presupuesto',
            'codigo'            => 2,
            'descripcion'       => 'En Ejecución',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_Presupuesto',
            'codigo'            => 3,
            'descripcion'       => 'Cerrado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));


        // $this->insert('metacodigo',array(
        //     'nombre_lista'      => 'Estado_Rendicion_CH',
        //     'codigo'            => 1,
        //     'descripcion'       => 'En Digitación',
        //     'descripcion2'      => '',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1,
        // ));
        // $this->insert('metacodigo',array(
        //     'nombre_lista'      => 'Estado_Rendicion_CH',
        //     'codigo'            => 2,
        //     'descripcion'       => 'Aprobada',
        //     'descripcion2'      => '',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1,
        // ));
        // $this->insert('metacodigo',array(
        //     'nombre_lista'      => 'Estado_Rendicion_CH',
        //     'codigo'            => 3,
        //     'descripcion'       => 'Anulado',
        //     'descripcion2'      => '',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1,
        // ));
        // $this->insert('metacodigo',array(
        //     'nombre_lista'      => 'Estado_Rendicion_CH',
        //     'codigo'            => 4,
        //     'descripcion'       => 'Por Aprobar Contabilidad',
        //     'descripcion2'      => '',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1,
        // ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_paso',
            'codigo'            => 1,
            'descripcion'       => 'En Digitación',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_paso',
            'codigo'            => 2,
            'descripcion'       => 'Por Aprobar',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_paso',
            'codigo'            => 3,
            'descripcion'       => 'Aprobado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_paso',
            'codigo'            => 4,
            'descripcion'       => 'Desaprobado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_Rendicion_Viatico',
            'codigo'            => 1,
            'descripcion'       => 'Anulado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_Rendicion_Viatico',
            'codigo'            => 2,
            'descripcion'       => 'En digitación',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_flujo',
            'codigo'            => 6,
            'descripcion'       => 'Adquisición',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_paso',
            'codigo'            => 5,
            'descripcion'       => 'Secuencia',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_paso',
            'codigo'            => 6,
            'descripcion'       => 'Desembolso',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_paso',
            'codigo'            => 7,
            'descripcion'       => 'Contrato',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_flujo',
            'codigo'            => 6,
            'descripcion'       => 'Contrato',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_flujo',
            'codigo'            => 7,
            'descripcion'       => 'Trámite Documentario',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_flujo',
            'codigo'            => 8,
            'descripcion'       => 'Entregable',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_flujo',
            'codigo'            => 9,
            'descripcion'       => 'Penalidad',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        //Para rendiciones genericas
        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Bien_Servicio',
            'codigo'            => 1,
            'descripcion'       => 'Bien',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Bien_Servicio',
            'codigo'            => 2,
            'descripcion'       => 'Servicio',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Documento_Rendicion',
            'codigo'            => 1,
            'descripcion'       => 'Boleta',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Documento_Rendicion',
            'codigo'            => 2,
            'descripcion'       => 'Factura',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Documento_Rendicion',
            'codigo'            => 3,
            'descripcion'       => 'Ticket',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Revision',
            'codigo'            => 1,
            'descripcion'       => 'Ex ANTE',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Revision',
            'codigo'            => 2,
            'descripcion'       => 'Ex POST',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 1,
            'descripcion'       => 'Licitación pública - Bienes',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 2,
            'descripcion'       => 'Licitación pública - Obras',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 3,
            'descripcion'       => 'Concurso público',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 4,
            'descripcion'       => 'Adjudicación simplificada - Bienes',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 5,
            'descripcion'       => 'Adjudicación simplificada - Servicios',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 6,
            'descripcion'       => 'Adjudicación simplificada - Obras',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 7,
            'descripcion'       => 'Selección de consultores individuales',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 8,
            'descripcion'       => 'Subasta inversa electrónica - Bienes',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 9,
            'descripcion'       => 'Subasta inversa electrónica - Servicios',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 10,
            'descripcion'       => 'Comparación de precios - Bienes',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Categoria_Adquisicion',
            'codigo'            => 11,
            'descripcion'       => 'Comparación de precios - Servicios',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Enfoque_Mercado',
            'codigo'            => 1,
            'descripcion'       => 'Limitado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Enfoque_Mercado',
            'codigo'            => 2,
            'descripcion'       => 'Ilimitado',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_Actividad',
            'codigo'            => 1,
            'descripcion'       => 'Completada',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_Actividad',
            'codigo'            => 2,
            'descripcion'       => 'Pendiente',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Estado_paso',
            'codigo'            => 8,
            'descripcion'       => 'Adquisición',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_conformidad',
            'codigo'            => 1,
            'descripcion'       => 'Conforme',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_conformidad',
            'codigo'            => 2,
            'descripcion'       => 'Sin conformidad',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Garantia',
            'codigo'            => 1,
            'descripcion'       => 'Años',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Garantia',
            'codigo'            => 2,
            'descripcion'       => 'Meses',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('metacodigo',array(
            'nombre_lista'      => 'Tipo_Garantia',
            'codigo'            => 3,
            'descripcion'       => 'Días',
            'descripcion2'      => '',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));





////////MÓDULOS////////
        $this->insert('modulo',array(
            'nombre'      => 'Seguridad', //modulo_id = 1
            'descripcion'       => 'Módulo de seguridad',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('modulo',array(
            'nombre'      => 'Patrimonio', //modulo_id = 2
            'descripcion'       => 'Módulo de patrimonio',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('modulo',array(
            'nombre'            => 'Recursos Humanos', //modulo_id = 3
            'descripcion'       => 'Módulo de recursos humanos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('modulo',array(
            'nombre'            => 'Contabilidad', //modulo_id = 4
            'descripcion'       => 'Módulo de Fondos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('modulo',array(
            'nombre'            => 'Administración', //modulo_id = 5
            'descripcion'       => 'Módulo de administración',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('modulo',array(
            'nombre'            => 'Contratos', //modulo_id = 6
            'descripcion'       => 'Módulo de contrataciones',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('modulo',array(
            'nombre'            => 'Trámite documentario', //modulo_id = 7
            'descripcion'       => 'Módulo de trámites documentarios',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('modulo',array(
            'nombre'            => 'Logística', //modulo_id = 8
            'descripcion'       => 'Módulo de logística',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('modulo',array(
            'nombre'            => 'Presupuestos', //modulo_id = 9
            'descripcion'       => 'Módulo de Presupuestos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));


////////PROCESOS////////
        $this->insert('proceso',array(
            'modulo_id'      => 1,
            'descripcion'       => 'Gestión de usuarios',
            'url_accion'      => 'Auditoria/usuario',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 1,
            'descripcion'       => 'Gestión de roles',
            'url_accion'      => 'Auditoria/rol',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 1,
            'descripcion'       => 'Gestión de módulos',
            'url_accion'      => 'Auditoria/modulo',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 1,
            'descripcion'       => 'Gestión de procesos',
            'url_accion'      => 'Auditoria/proceso',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        // $this->insert('proceso',array(
        //     'modulo_id'      => 2,
        //     'descripcion'       => 'Gestión de documentos',
        //     'url_accion'      => 'Patrimonio/documento-pnia',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1,
        // ));
        $this->insert('proceso',array(
            'modulo_id'      => 2,
            'descripcion'       => 'Gestión de metacódigos',
            'url_accion'      => 'Patrimonio/metacodigo',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 2,
            'descripcion'       => 'Gestión de clases de patrimonio',
            'url_accion'      => 'Patrimonio/patrimonio-clase',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 2,
            'descripcion'       => 'Gestión de inventarios',
            'url_accion'      => 'Patrimonio/patrimonio-inventario',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 2,
            'descripcion'       => 'Gestión de items',
            'url_accion'      => 'Patrimonio/patrimonio-item',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 2,
            'descripcion'       => 'Gestión de movimientos de patrimonio',
            'url_accion'      => 'Patrimonio/patrimonio-movimiento',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 2,
            'descripcion'       => 'Gestión de valorización',
            'url_accion'      => 'Patrimonio/patrimonio-valorizacion',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 2,
            'descripcion'       => 'Gestión de ubicaciones',
            'url_accion'      => 'Patrimonio/ubicacion',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('proceso',array(
            'modulo_id'      => 8,
            'descripcion'       => 'Gestión de entidades financieras',
            'url_accion'      => 'rrhh/pnia-ent-financiera',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 8,
            'descripcion'       => 'Gestión de entidades',
            'url_accion'      => 'rrhh/pnia-entidad',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 3,
            'descripcion'       => 'Gestión de áreas',
            'url_accion'      => 'rrhh/staff-area',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 3,
            'descripcion'       => 'Gestión de personas',
            'url_accion'      => 'rrhh/staff-persona',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Gestión de árbol pnia',
            'url_accion'      => 'Viatico/arbol-pnia',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Gestión de distribución de monto',
            'url_accion'      => 'Viatico/fondo-distribucion-monto',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Gestión de fondo de viático',
            'url_accion'      => 'Viatico/fondo-viatico',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Gestión de fondo de caja chica',
            'url_accion'      => 'Viatico/fondo-caja-chica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Gestión de fondo de entrega',
            'url_accion'      => 'Viatico/fondo-entrega',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Gestión de fondo de desembolso',
            'url_accion'      => 'Viatico/fondo-desembolso',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Gestión de rendición de caja chica',
            'url_accion'      => 'Viatico/fondo-rendicion-caja-chica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Gestión de rendición de encargo',
            'url_accion'      => 'Viatico/fondo-rendicion-encargo',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Gestión de rendición de genérico',
            'url_accion'      => 'Viatico/fondo-rendicion-generico',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Gestión de rendición de viático',
            'url_accion'      => 'Viatico/fondo-rendicion-viatico',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('proceso',array(
            'modulo_id'      => 5,
            'descripcion'       => 'Gestión de flujo',
            'url_accion'      => 'Viatico/flujo-flujo',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(//27
            'modulo_id'      => 8,
            'descripcion'       => 'Gestión de adquisiciones',
            'url_accion'      => 'General/gestion-adquisicion',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 5,
            'descripcion'       => 'Gestión de procesos',
            'url_accion'      => 'Viatico/flujo-requerimiento',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('proceso',array(
            'modulo_id'      => 6,
            'descripcion'       => 'Gestión de cartas fianza',
            'url_accion'      => 'rrhh/contrato-carta-fianza',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 6,
            'descripcion'       => 'Gestión de contratos',
            'url_accion'      => 'rrhh/contrato-contrato',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('proceso',array(
            'modulo_id'      => 3,
            'descripcion'       => 'Gestión de contratos de recursos humanos',
            'url_accion'      => 'rrhh/contrato-contrato-rrhh',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 8,
            'descripcion'       => 'Adquisición',
            'url_accion'      => 'Adquisicion/adquisicion',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 7,
            'descripcion'       => 'Gestión de trámite documentario',
            'url_accion'      => 'General/tramite-documentario',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Viatico/gestion-rendicion-viatico',
            'url_accion'      => 'Viatico/gestion-rendicion-viatico',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Viatico/gestion-rendicion-caja-chica',
            'url_accion'      => 'Viatico/gestion-rendicion-caja-chica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Viatico/gestion-rendicion-encargo',
            'url_accion'      => 'Viatico/gestion-rendicion-encargo',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 6,
            'descripcion'       => 'Conformidad de entregables (Contratos)',
            'url_accion'      => 'rrhh/conformidad-entregable',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        /// proceso 38
        $this->insert('proceso',array(
            'modulo_id'      => 9,
            'descripcion'       => 'Gestión por Líneas',
            'url_accion'        => 'Presupuesto/presupuesto-cabecera-final',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        /// proceso 39
        $this->insert('proceso',array(
            'modulo_id'      => 9,
            'descripcion'       => 'Gestión de Categoría/Producto',
            'url_accion'        => 'presupuesto/categoria-producto',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        /// proceso 40
        $this->insert('proceso',array(
            'modulo_id'      => 9,
            'descripcion'       => 'Gestión de Versiones',
            'url_accion'        => 'Presupuesto/presupuesto-version',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        /// proceso 41
        $this->insert('proceso',array(
            'modulo_id'      => 9,
            'descripcion'       => 'Gestión de Partidas',
            'url_accion'        => 'Presupuesto/partida',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        /// proceso 42
        $this->insert('proceso',array(
            'modulo_id'      => 9,
            'descripcion'       => 'Asignación presupuestal',
            'url_accion'        => 'Viatico/arbol-area',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        /// proceso 43
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Viatico/fondo-viatico-detalle',
            'url_accion'        => 'Viatico/fondo-viatico-detalle',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        /// proceso 44
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Viatico/gestion-rendicion-viatico',
            'url_accion'        => 'Viatico/gestion-rendicion-viatico',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         /// proceso 45
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Viatico/gestion-rendicion-caja-chica',
            'url_accion'        => 'Viatico/gestion-rendicion-caja-chica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         /// proceso 46
        $this->insert('proceso',array(
            'modulo_id'      => 4,
            'descripcion'       => 'Viatico/gestion-rendicion-encargo',
            'url_accion'        => 'Viatico/gestion-rendicion-encargo',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

         /// proceso 47
        $this->insert('proceso',array(
            'modulo_id'      => 6,
            'descripcion'       => 'rrhh/contrato-entregable',
            'url_accion'        => 'rrhh/contrato-entregable',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        /// proceso 48
        $this->insert('proceso',array(
            'modulo_id'      => 6,
            'descripcion'       => 'rrhh/contrato-penalidad',
            'url_accion'        => 'rrhh/contrato-penalidad',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        /// proceso 49
        $this->insert('proceso',array(
            'modulo_id'      => 5,
            'descripcion'       => 'Viatico/flujo-paso',
            'url_accion'        => 'Viatico/flujo-paso',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

         /// proceso 50
        $this->insert('proceso',array(
            'modulo_id'      => 9,
            'descripcion'       => 'Gestión de Contratos - Presupuesto',
            'url_accion'        => 'presupuesto/presupuesto-contrato',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         /// proceso 51
        $this->insert('proceso',array(
            'modulo_id'      => 9,
            'descripcion'       => 'Gestión de Objetivos Estratégicos',
            'url_accion'        => 'presupuesto/objetivo-estrategico',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         /// proceso 52
        $this->insert('proceso',array(
            'modulo_id'      => 9,
            'descripcion'       => 'Gestión de Acciones Estratégicas',
            'url_accion'        => 'presupuesto/accion-estrategica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         /// proceso 53
        $this->insert('proceso',array(
            'modulo_id'      => 9,
            'descripcion'       => 'Gestión de Metas',
            'url_accion'        => 'presupuesto/meta',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
         /// proceso 54
        $this->insert('proceso',array(
            'modulo_id'      => 9,
            'descripcion'       => 'Gestión de Unidad de Medida',
            'url_accion'        => 'presupuesto/unidad-medida',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));



////////ROLES////////
        $this->insert('rol',array(
            'nombre'      => 'Administrador Master', //rol_ = 1
            'descripcion'       => 'Todos los permisos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol',array(
            'nombre'      => 'Administración', //rol_ = 2
            'descripcion'       => 'Permisos módulo de Administración',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol',array(
            'nombre'      => 'Contabilidad', //rol_ = 3
            'descripcion'       => 'Permisos módulo de Contabilidad',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol',array(
            'nombre'      => 'Contratos', //rol_ = 4
            'descripcion'       => 'Permisos módulo de Contratos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol',array(
            'nombre'      => 'Logística', //rol_ = 5
            'descripcion'       => 'Permisos módulo de Logística',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol',array(
            'nombre'      => 'Patrimonio', //rol_ = 6
            'descripcion'       => 'Permisos módulo de Patrimonio',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol',array(
            'nombre'      => 'Recursos Humanos', //rol_ = 7
            'descripcion'       => 'Permisos módulo de Recursos Humanos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol',array(
            'nombre'      => 'Seguridad', //rol_ = 8
            'descripcion'       => 'Permisos módulo de Seguridad',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol',array(
            'nombre'      => 'Trámite documentario', //rol_ = 9
            'descripcion'       => 'Permisos módulo de Trámite documentario',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol',array(
            'nombre'      => 'Presupuestador', //rol_ = 10
            'descripcion'       => 'Permisos Sobre los Presupuestos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('rol',array(
            'nombre'      => 'Planificador de Presupuestos', //rol_ = 11
            'descripcion'       => 'Permisos Sobre los Presupuestos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

////////PERMISOS A MASTER////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 1,
            'permiso'           => 'Auditoria/usuario',
            'descripcion'       => 'Gestión de usuarios',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 2,
            'permiso'           => 'Auditoria/rol',
            'descripcion'       => 'Gestión de roles',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 3,
            'permiso'           => 'Auditoria/modulo',
            'descripcion'       => 'Gestión de módulos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 4,
            'permiso'           => 'Auditoria/proceso',
            'descripcion'       => 'Gestión de procesos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 5,
            'permiso'           => 'Patrimonio/metacodigo',
            'descripcion'       => 'Gestión de metacódigos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
                        'mostrar_en_arbol'  => 0,
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 6,
            'permiso'           => 'Patrimonio/patrimonio-clase',
            'descripcion'       => 'Gestión de clases de patrimonio',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 7,
            'permiso'           => 'Patrimonio/patrimonio-inventario',
            'descripcion'       => 'Gestión de invenitarios',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 8,
            'permiso'           => 'Patrimonio/patrimonio-item',
            'descripcion'       => 'Gestión de items',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 9,
            'permiso'           => 'Patrimonio/patrimonio-movimiento',
            'descripcion'       => 'Gestión de movimientos de patrimonio',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 10,
            'permiso'           => 'Patrimonio/patrimonio-valorizacion',
            'descripcion'       => 'Gestión de valorización',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 11,
            'permiso'           => 'Patrimonio/ubicacion',
            'descripcion'       => 'Gestión de ubicaciones',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 12,
            'permiso'           => 'rrhh/pnia-ent-financiera',
            'descripcion'       => 'Gestión de entidades financieras',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 13,
            'permiso'           => 'rrhh/pnia-entidad',
            'descripcion'       => 'Gestión de entidades',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 14,
            'permiso'           => 'rrhh/staff-area',
            'descripcion'       => 'Gestión de áreas',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 15,
            'permiso'           => 'rrhh/staff-persona',
            'descripcion'       => 'Gestión de personas',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        // $this->insert('rol_proceso',array(
        //     'rol_id'            => 1,
        //     'proceso_id'        => 16,
        //     'permiso'           => 'Viatico/arbol-pnia',
        //     'descripcion'       => 'Gestión de árbol pnia',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 17,
            'permiso'           => 'Viatico/fondo-distribucion-monto',
            'descripcion'       => 'Gestión de distribución de monto',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 18,
            'permiso'           => 'Viatico/fondo-viatico',
            'descripcion'       => 'Gestión de fondo de viático',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 19,
            'permiso'           => 'Viatico/fondo-caja-chica',
            'descripcion'       => 'Gestión de fondo de caja chica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 20,
            'permiso'           => 'Viatico/fondo-entrega',
            'descripcion'       => 'Gestión de fondo de entrega',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 21,
            'permiso'           => 'Viatico/fondo-desembolso',
            'descripcion'       => 'Gestión de fondo de desembolso',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 22,
            'permiso'           => 'Viatico/fondo-rendicion-caja-chica',
            'descripcion'       => 'Gestión de rendición de caja chica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 23,
            'permiso'           => 'Viatico/fondo-rendicion-encargo',
            'descripcion'       => 'Gestión de rendición de entrega',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        // $this->insert('rol_proceso',array(
        //     'rol_id'            => 1,
        //     'proceso_id'        => 24,
        //     'permiso'           => 'Viatico/fondo-rendicion-generico',
        //     'descripcion'       => 'Gestión de rendición genérico',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 25,
            'permiso'           => 'Viatico/fondo-rendicion-viatico',
            'descripcion'       => 'Gestión de rendición de viático',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 26,
            'permiso'           => 'Viatico/flujo-flujo',
            'descripcion'       => 'Gestión de flujo',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 27,
            'permiso'           => 'General/gestion-adquisicion',
            'descripcion'       => 'Gestión de adquisiciones',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 28,
            'permiso'           => 'Viatico/flujo-requerimiento',
            'descripcion'       => 'Gestión de procesos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 29,
            'permiso'           => 'rrhh/contrato-carta-fianza',
            'descripcion'       => 'Gestión de cartas fianza',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 30,
            'permiso'           => 'rrhh/contrato-contrato',
            'descripcion'       => 'Gestión de contratos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 31,
            'permiso'           => 'rrhh/contrato-contrato-rrhh',
            'descripcion'       => 'Gestión de contratos de recursos humanos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 32,
            'permiso'           => 'Adquisicion/adquisicion',
            'descripcion'       => 'Gestión de adquisiciones',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 33,
            'permiso'           => 'General/tramite-documentario',
            'descripcion'       => 'Gestión de trámite documentario',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 37,
            'permiso'           => 'rrhh/conformidad-entregable',
            'descripcion'       => 'Conformidad de entregables (Contratos)',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));



        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 43,
            'permiso'           => 'Viatico/fondo-viatico-detalle',
            'descripcion'       => 'Viatico/fondo-viatico-detalle',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 44,
            'permiso'           => 'Viatico/gestion-rendicion-viatico',
            'descripcion'       => 'Viatico/gestion-rendicion-viatico',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 45,
            'permiso'           => 'Viatico/gestion-rendicion-caja-chica',
            'descripcion'       => 'Viatico/gestion-rendicion-caja-chica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0

        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 46,
            'permiso'           => 'Viatico/fondo-viatico-detalle',
            'descripcion'       => 'Viatico/fondo-viatico-detalle',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 47,
            'permiso'           => 'rrhh/contrato-entregable',
            'descripcion'       => 'rrhh/contrato-entregable',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));


        // $this->insert('rol_proceso',array(
        //     'rol_id'            => 1,
        //     'proceso_id'        => 34,
        //     'permiso'           => 'Viatico/gestion-rendicion-viatico',
        //     'descripcion'       => 'Viatico/gestion-rendicion-viatico',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        // $this->insert('rol_proceso',array(
        //     'rol_id'            => 1,
        //     'proceso_id'        => 35,
        //     'permiso'           => 'Viatico/gestion-rendicion-caja-chica',
        //     'descripcion'       => 'Viatico/gestion-rendicion-caja-chica',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        // $this->insert('rol_proceso',array(
        //     'rol_id'            => 1,
        //     'proceso_id'        => 36,
        //     'permiso'           => 'Viatico/gestion-rendicion-encargo',
        //     'descripcion'       => 'Viatico/gestion-rendicion-encargo',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
///////////////// ADMINISTRACIÓN ROL_PROCESO /////////////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 2,
            'proceso_id'        => 28,
            'permiso'           => 'Viatico/flujo-requerimiento',
            'descripcion'       => 'Gestión de procesos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 2,
            'proceso_id'        => 26,
            'permiso'           => 'Viatico/flujo-flujo',
            'descripcion'       => 'Gestión de flujo',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
//////////////////////////////////////////////////////////////

///////////////// CONTABILIDAD ROL_PROCESO /////////////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 17,
            'permiso'           => 'Viatico/fondo-distribucion-monto',
            'descripcion'       => 'Gestión de distribución de monto',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 18,
            'permiso'           => 'Viatico/fondo-viatico',
            'descripcion'       => 'Gestión de fondo de viático',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 19,
            'permiso'           => 'Viatico/fondo-caja-chica',
            'descripcion'       => 'Gestión de fondo de caja chica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 20,
            'permiso'           => 'Viatico/fondo-entrega',
            'descripcion'       => 'Gestión de fondo de entrega',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 21,
            'permiso'           => 'Viatico/fondo-desembolso',
            'descripcion'       => 'Gestión de fondo de desembolso',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 22,
            'permiso'           => 'Viatico/fondo-rendicion-caja-chica',
            'descripcion'       => 'Gestión de rendición de caja chica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 23,
            'permiso'           => 'Viatico/fondo-rendicion-encargo',
            'descripcion'       => 'Gestión de rendición de entrega',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        // $this->insert('rol_proceso',array(////////
        //     'rol_id'            => 3,
        //     'proceso_id'        => 24,
        //     'permiso'           => 'Viatico/fondo-rendicion-generico',
        //     'descripcion'       => 'Gestión de rendición genérico',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 25,
            'permiso'           => 'Viatico/fondo-rendicion-viatico',
            'descripcion'       => 'Gestión de rendición de viático',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 43,
            'permiso'           => 'Viatico/fondo-viatico-detalle',
            'descripcion'       => 'Viatico/fondo-viatico-detalle',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 44,
            'permiso'           => 'Viatico/gestion-rendicion-viatico',
            'descripcion'       => 'Viatico/gestion-rendicion-viatico',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 45,
            'permiso'           => 'Viatico/gestion-rendicion-caja-chica',
            'descripcion'       => 'Viatico/gestion-rendicion-caja-chica',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0

        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 3,
            'proceso_id'        => 46,
            'permiso'           => 'Viatico/fondo-viatico-detalle',
            'descripcion'       => 'Viatico/fondo-viatico-detalle',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
//////////////////////////////////////////////////////////////

///////////////// CONTRATOS ROL_PROCESO /////////////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 4,
            'proceso_id'        => 29,
            'permiso'           => 'rrhh/contrato-carta-fianza',
            'descripcion'       => 'Gestión de cartas fianza',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 4,
            'proceso_id'        => 30,
            'permiso'           => 'rrhh/contrato-contrato',
            'descripcion'       => 'Gestión de contratos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 4,
            'proceso_id'        => 37,
            'permiso'           => 'rrhh/conformidad-entregable',
            'descripcion'       => 'Conformidad de entregables (Contratos)',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 4,
            'proceso_id'        => 47,
            'permiso'           => 'rrhh/contrato-entregable',
            'descripcion'       => 'rrhh/contrato-entregable',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 4,
            'proceso_id'        => 48,
            'permiso'           => 'rrhh/contrato-penalidad',
            'descripcion'       => 'rrhh/contrato-penalidad',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
//////////////////////////////////////////////////////////////

///////////////// LOGÌSTICA ROL_PROCESO /////////////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 5,
            'proceso_id'        => 32,
            'permiso'           => 'Adquisicion/adquisicion',
            'descripcion'       => 'Gestión de adquisiciones',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 5,
            'proceso_id'        => 27,
            'permiso'           => 'General/gestion-adquisicion',
            'descripcion'       => 'Gestión de adquisiciones',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 5,
            'proceso_id'        => 12,
            'permiso'           => 'rrhh/pnia-ent-financiera',
            'descripcion'       => 'Gestión de entidades financieras',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 5,
            'proceso_id'        => 13,
            'permiso'           => 'rrhh/pnia-entidad',
            'descripcion'       => 'Gestión de entidades',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
//////////////////////////////////////////////////////////////

///////////////// PATRIMONIO ROL_PROCESO /////////////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 6,
            'proceso_id'        => 6,
            'permiso'           => 'Patrimonio/patrimonio-clase',
            'descripcion'       => 'Gestión de clases de patrimonio',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 6,
            'proceso_id'        => 7,
            'permiso'           => 'Patrimonio/patrimonio-inventario',
            'descripcion'       => 'Gestión de invenitarios',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 6,
            'proceso_id'        => 8,
            'permiso'           => 'Patrimonio/patrimonio-item',
            'descripcion'       => 'Gestión de items',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 6,
            'proceso_id'        => 9,
            'permiso'           => 'Patrimonio/patrimonio-movimiento',
            'descripcion'       => 'Gestión de movimientos de patrimonio',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 6,
            'proceso_id'        => 10,
            'permiso'           => 'Patrimonio/patrimonio-valorizacion',
            'descripcion'       => 'Gestión de valorización',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 6,
            'proceso_id'        => 11,
            'permiso'           => 'Patrimonio/ubicacion',
            'descripcion'       => 'Gestión de ubicaciones',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
//////////////////////////////////////////////////////////////

///////////////// RECURSOS HUMANOS ROL_PROCESO /////////////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 7,
            'proceso_id'        => 31,
            'permiso'           => 'rrhh/contrato-contrato-rrhh',
            'descripcion'       => 'Gestión de contratos de recursos humanos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 7,
            'proceso_id'        => 14,
            'permiso'           => 'rrhh/staff-area',
            'descripcion'       => 'Gestión de áreas',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 7,
            'proceso_id'        => 15,
            'permiso'           => 'rrhh/staff-persona',
            'descripcion'       => 'Gestión de personas',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
//////////////////////////////////////////////////////////////

///////////////// SEGURIDAD ROL_PROCESO /////////////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 8,
            'proceso_id'        => 1,
            'permiso'           => 'Auditoria/usuario',
            'descripcion'       => 'Gestión de usuarios',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 8,
            'proceso_id'        => 2,
            'permiso'           => 'Auditoria/rol',
            'descripcion'       => 'Gestión de roles',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
//////////////////////////////////////////////////////////////

///////////////// TRÁMITE DOCUMENTARIO ROL_PROCESO /////////////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 9,
            'proceso_id'        => 33,
            'permiso'           => 'General/tramite-documentario',
            'descripcion'       => 'Gestión de trámite documentario',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
/////////////////////SIGUE CONTABILIDAD//////////////////////////////
        // $this->insert('rol_proceso',array(
        //     'rol_id'            => 3,
        //     'proceso_id'        => 34,
        //     'permiso'           => 'Viatico/gestion-rendicion-viatico',
        //     'descripcion'       => 'Viatico/gestion-rendicion-viatico',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        // $this->insert('rol_proceso',array(
        //     'rol_id'            => 3,
        //     'proceso_id'        => 35,
        //     'permiso'           => 'Viatico/gestion-rendicion-caja-chica',
        //     'descripcion'       => 'Viatico/gestion-rendicion-caja-chica',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        // $this->insert('rol_proceso',array(
        //     'rol_id'            => 3,
        //     'proceso_id'        => 36,
        //     'permiso'           => 'Viatico/gestion-rendicion-encargo',
        //     'descripcion'       => 'Viatico/gestion-rendicion-encargo',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));



//////////////////////////////////////////////////////////////

///////////////// PRESUPUESTADOR ROL_PROCESO /////////////////

        $this->insert('rol_proceso',array(
            'rol_id'            => 10,
            'proceso_id'        => 38,
            'permiso'           => 'Presupuesto/presupuesto-cabecera-final',
            'descripcion'       => 'Vista General de Presupuestos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 10,
            'proceso_id'        => 39,
            'permiso'           => 'presupuesto/categoria-producto',
            'descripcion'       => 'Gestión de Categoría/Producto',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 10,
            'proceso_id'        => 40,
            'permiso'           => 'Presupuesto/presupuesto-version',
            'descripcion'       => 'Administración de Versiones',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 10,
            'proceso_id'        => 41,
            'permiso'           => 'Presupuesto/partida',
            'descripcion'       => 'Administración de Partidas',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 10,
            'proceso_id'        => 42,
            'permiso'           => 'Viatico/arbol-area',
            'descripcion'       => 'Asignación presupuestal',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 10,
            'proceso_id'        => 50,
            'permiso'           => 'presupuesto/presupuesto-contrato',
            'descripcion'       => 'Gestión de Contratos - Presupuesto',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 10,
            'proceso_id'        => 51,
            'permiso'           => 'presupuesto/objetivo-estrategico',
            'descripcion'       => 'Objetivos Estratégicos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

         $this->insert('rol_proceso',array(
            'rol_id'            => 10,
            'proceso_id'        => 52,
            'permiso'           => 'presupuesto/accion-estrategica',
            'descripcion'       => 'Gestión de Acciones Estratégicas',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

         $this->insert('rol_proceso',array(
            'rol_id'            => 10,
            'proceso_id'        => 53,
            'permiso'           => 'presupuesto/meta',
            'descripcion'       => 'Gestión de Metas',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

         $this->insert('rol_proceso',array(
            'rol_id'            => 10,
            'proceso_id'        => 54,
            'permiso'           => 'presupuesto/unidad-medida',
            'descripcion'       => 'Gestión de Unidad de Medida',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

//////////////////////////////////////////////////////////////

////////////////// PLANIFICADOR ROL_PROCESO //////////////////


        $this->insert('rol_proceso',array(
            'rol_id'            => 11,
            'proceso_id'        => 38,
            'permiso'           => 'Presupuesto/presupuesto-cabecera-final',
            'descripcion'       => 'Vista General de Presupuestos',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 11,
            'proceso_id'        => 39,
            'permiso'           => 'Presupuesto/presupuesto',
            'descripcion'       => 'Vista de Presupuestos por Periodo',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 11,
            'proceso_id'        => 40,
            'permiso'           => 'Presupuesto/presupuesto-version',
            'descripcion'       => 'Administración de Versiones',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 11,
            'proceso_id'        => 41,
            'permiso'           => 'Presupuesto/partida',
            'descripcion'       => 'Administración de Partidas',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
////continuacion master///////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 49,
            'permiso'           => 'Viatico/flujo-paso',
            'descripcion'       => 'Viatico/flujo-paso',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 2,
            'proceso_id'        => 49,
            'permiso'           => 'Viatico/flujo-paso',
            'descripcion'       => 'Viatico/flujo-paso',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));

        ///////CONTINUACION DE LOS RESTANTES AL ROL DE RRHH CONTRATOS ENTREGABLES Y PENALIDADES/////////////
        $this->insert('rol_proceso',array(
            'rol_id'            => 7,
            'proceso_id'        => 47,
            'permiso'           => 'rrhh/contrato-entregable',
            'descripcion'       => 'Contrato Entregable',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 7,
            'proceso_id'        => 48,
            'permiso'           => 'rrhh/contrato-penalidad',
            'descripcion'       => 'Contrato Penalidad',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));
        $this->insert('rol_proceso',array(
            'rol_id'            => 7,
            'proceso_id'        => 30,
            'permiso'           => 'rrhh/contrato-contrato',
            'descripcion'       => 'Contrato Contrato',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0
        ));


////////ROL PROCESO ACCION////////
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 1,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 1,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 1,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 1,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 1,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 2,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 2,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 2,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 2,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 2,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 3,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 3,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 3,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 3,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 3,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 4,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 4,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 4,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 4,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 4,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 5,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 5,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 5,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 5,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 5,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 6,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 6,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 6,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 6,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 6,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 7,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 7,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 7,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 7,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 7,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 8,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 8,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 8,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 8,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 8,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 9,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 9,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 9,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 9,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 9,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 10,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 10,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 10,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 10,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 10,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 11,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 11,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 11,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 11,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 11,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 12,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 12,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 12,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 12,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 12,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 13,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 13,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 13,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 13,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 13,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 14,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 14,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 14,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 14,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 14,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 15,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 15,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 15,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 15,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 15,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 16,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 16,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 16,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 16,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 16,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 17,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 17,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 17,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 17,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 17,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 18,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 18,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 18,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 18,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 18,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 19,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 19,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 19,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 19,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 19,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 20,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 20,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 20,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 20,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 20,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 21,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 21,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 21,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 21,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 21,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 22,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 22,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 22,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 22,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 22,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 23,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 23,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 23,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 23,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 23,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 24,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 24,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 24,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 24,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 24,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 25,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 25,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 25,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 25,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 25,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 26,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 26,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 26,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 26,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 26,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 27,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 27,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 27,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 27,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 27,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 28,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 28,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 28,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 28,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 28,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 29,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 29,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 29,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 29,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 29,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 30,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 30,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 30,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 30,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 30,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 31,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 31,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 31,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 31,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 31,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 32,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 32,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 32,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 32,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 32,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        // $this->insert('rol_proceso_accion',array(
        //     'rol_proceso_id'    => 33,
        //     'accion'            => 'index',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 33,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 33,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 33,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 33,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        // $this->insert('rol_proceso_accion',array(
        //     'rol_proceso_id'    => 34,
        //     'accion'            => 'index',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 34,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        // $this->insert('rol_proceso_accion',array(
        //     'rol_proceso_id'    => 34,
        //     'accion'            => 'create',
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 34,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 34,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        // $this->insert('rol_proceso_accion',array(
        //     'rol_proceso_id'    => 35,
        //     'accion'            => 'index',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 35,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 35,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 35,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 35,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        // $this->insert('rol_proceso_accion',array(
        //     'rol_proceso_id'    => 36,
        //     'accion'            => 'index',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 36,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 36,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 36,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 36,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        // $this->insert('rol_proceso_accion',array(
        //     'rol_proceso_id'    => 37,
        //     'accion'            => 'index',
        //     'creado_en'         => date('Y-m-d H:i:s'),
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 37,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 37,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 37,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 37,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 38,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 38,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 38,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 38,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 38,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 39,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 39,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 39,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 39,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 39,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 40,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 40,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 40,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 40,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 40,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 41,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 41,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 41,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 41,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 41,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 42,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 42,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 42,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 42,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 42,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 43,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 43,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 43,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 43,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 43,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 44,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 44,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 44,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 44,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 44,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 45,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 45,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 45,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 45,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 45,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 46,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 46,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 46,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 46,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 46,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 47,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 47,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 47,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 47,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 47,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 48,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 48,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        // $this->insert('rol_proceso_accion',array(
        //     'rol_proceso_id'    => 48,
        //     'accion'            => 'create',
        //     'actualizado_en'    => date('Y-m-d H:i:s'),
        //     'creado_por'        => 1,
        //     'actualizado_por'   => 1
        // ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 48,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 48,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 49,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 49,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 49,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 49,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 49,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 50,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 50,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 50,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 50,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 50,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 51,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 51,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 51,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 51,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 51,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 52,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 52,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 52,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 52,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 52,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 53,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 53,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 53,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 53,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 53,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 54,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 54,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 54,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 54,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 54,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 55,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 55,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 55,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 55,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 55,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 56,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 56,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 56,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 56,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 56,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 57,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 57,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 57,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 57,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 57,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 58,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 58,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 58,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 58,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 58,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 59,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 59,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 59,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 59,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 59,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 60,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 60,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 60,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 60,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 60,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 61,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 61,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 61,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 61,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 61,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 62,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 62,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 62,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 62,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 62,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 63,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 63,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 63,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 63,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 63,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 64,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 64,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 64,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 64,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 64,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 65,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 65,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 65,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 65,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 65,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 66,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 66,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 66,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 66,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 66,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 67,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 67,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 67,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 67,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 67,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 68,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 68,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 68,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 68,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 68,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 69,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 69,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 69,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 69,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 69,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 70,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 70,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 70,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 70,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 70,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 71,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 71,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 71,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 71,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 71,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 77,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 77,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 77,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 77,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 77,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));


        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 87,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 87,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 87,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 87,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));


        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 88,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 88,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 88,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 88,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

         $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 89,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 89,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 89,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 89,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

         $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 90,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 90,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 90,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 90,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

/////////////////////////////////////////////////////////////////////////////////////////////////

////////ASIGNACIÓN ROL A MASTER////////
        $this->insert('rol_usuario',array(
            'rol_id'      => 1,
            'usuario_id'       => 1,
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));














    /////////    //TODOS LOS NUEVOS PERMISOS DE AQUI EN ADELANTE  //////////////////
        $this->insert('proceso',array(
            'modulo_id'      => 5,
            'descripcion'       => 'Requerimiento Detalle',
            'url_accion'      => 'General/requerimiento-detalle',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));
        $this->insert('proceso',array(
            'modulo_id'      => 5,
            'descripcion'       => 'Postores',
            'url_accion'      => 'General/postores',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 55,
            'permiso'           => 'General/requerimiento-detalle',
            'descripcion'       => 'Detalle de Requerimiento',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0,
        ));

        $this->insert('rol_proceso',array(
            'rol_id'            => 1,
            'proceso_id'        => 56,
            'permiso'           => 'General/postores',
            'descripcion'       => 'Postores',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1,
            'mostrar_en_arbol'  => 0,
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 92,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 92,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 92,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 92,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 92,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));

        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 93,
            'accion'            => 'index',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 93,
            'accion'            => 'view',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 93,
            'accion'            => 'create',
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 93,
            'accion'            => 'update',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));
        $this->insert('rol_proceso_accion',array(
            'rol_proceso_id'    => 93,
            'accion'            => 'delete',
            'creado_en'         => date('Y-m-d H:i:s'),
            'actualizado_en'    => date('Y-m-d H:i:s'),
            'creado_por'        => 1,
            'actualizado_por'   => 1
        ));


    }
}
