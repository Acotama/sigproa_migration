<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El campo :attribute debe ser aceptado.',
    'active_url'           => 'El campo :attribute no es una URL válida.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
    'alpha'                => 'El campo :attribute sólo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute sólo puede contener letras, números y guiones (a-z, 0-9, -_).',
    'alpha_num'            => 'El campo :attribute sólo puede contener letras y números.',
    'array'                => 'El campo :attribute debe ser un array.',
    'before'               => 'El campo :attribute debe ser una fecha anterior a :date.',

    'between'              => [
        'numeric' => 'El campo :attribute debe ser un valor entre :min y :max.',
        'file'    => 'El archivo :attribute debe pesar entre :min y :max kilobytes.',
        'string'  => 'El campo :attribute debe contener entre :min y :max caracteres.',
        'array'   => 'El campo :attribute debe contener entre :min y :max elementos.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El campo confirmación de :attribute no coincide.',
    'country'              => 'El campo :attribute no es un país válido.',
    'date'                 => 'El campo :attribute no corresponde con una fecha válida.',
    'date_format'          => 'El campo :attribute no corresponde con el formato de fecha :format.',
    'different'            => 'Los campos :attribute y :other han de ser diferentes.',
    'digits'               => 'El campo :attribute debe ser un número de :digits dígitos.',
    'digits_between'       => 'El campo :attribute debe contener entre :min y :max dígitos.',
    'distinct'             => 'El campo :attribute tiene un valor duplicado.',
    'email'                => 'El campo :attribute no corresponde con una dirección de e-mail válida.',
    'filled'               => 'El campo :attribute es obligatorio.',
    'exists'               => 'El campo :attribute no existe.',
    'image'                => 'El campo :attribute debe ser una imagen.',
    'in'                   => 'El campo :attribute debe ser igual a alguno de estos valores :values',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => 'El campo :attribute debe ser un número entero.',
    'ip'                   => 'El campo :attribute debe ser una dirección IP válida.',
    'json'                 => 'El campo :attribute debe ser una cadena de texto JSON válida.',
    'max'                  => [
        'numeric' => 'El campo :attribute debe ser :max como máximo.',
        'file'    => 'El archivo :attribute debe pesar :max kilobytes como máximo.',
        'string'  => 'El campo :attribute debe contener :max caracteres como máximo.',
        'array'   => 'El campo :attribute debe contener :max elementos como máximo.',
    ],
    'mimes'                => 'El campo :attribute debe ser un archivo de tipo :values.',
    'min'                  => [
        'numeric' => 'El campo :attribute debe tener al menos :min.',
        'file'    => 'El archivo :attribute debe pesar al menos :min kilobytes.',
        'string'  => 'El campo :attribute debe contener al menos :min caracteres.',
        'array'   => 'El campo :attribute no debe contener más de :min elementos.',
    ],
    'not_in'               => 'El campo :attribute seleccionado es invalido.',
    'numeric'              => 'El campo :attribute debe ser un numero.',
    'present'              => 'El campo :attribute debe estar presente.',
    'regex'                => 'El formato del campo :attribute es inválido.',
    'required'             => 'El campo :attribute es obligatorio',
    'required_if'          => 'El campo :attribute es obligatorio cuando el campo :other es :value.',
    'required_unless'      => 'El campo :attribute es requerido a menos que :other se encuentre en :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ningún campo :values están presentes.',
    'same'                 => 'Los campos :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El campo :attribute debe ser :size.',
        'file'    => 'El archivo :attribute debe pesar :size kilobytes.',
        'string'  => 'El campo :attribute debe contener :size caracteres.',
        'array'   => 'El campo :attribute debe contener :size elementos.',
    ],
    'state'                => 'El estado no es válido para el país seleccionado.',
    'string'               => 'El campo :attribute debe contener solo caracteres.',
    'timezone'             => 'El campo :attribute debe contener una zona válida.',
    'unique'               => 'El elemento :attribute ya está en uso.',
    'url'                  => 'El formato de :attribute no corresponde con el de una URL válida.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        #Usuario
        'username' => 'Usuario',
        'password' => 'Contraseña',
        'email'    => 'E-mail',
        'dni'      => 'DNI',
        'apellidos'=> 'Apellidos',
        'nombres'  => 'Nombres',
        'cargo'    => 'Cargo',
        'celular'  => 'Celular',
        #PipTotalPriori
        'nom_proyec' => 'Nombre del Proyecto',
        'cod_snip' => 'Código SNIP',
        'cod_unif' => 'Código Unificado',
        'cod_dpto' => 'Código del departamento',
        'nom_dpto' => 'Nombre de Departamento',
        'cod_prov' => 'Código Provincia',
        'nom_prov' => 'Nombre Provincia',
        'cod_dist' => 'Código Distrito',
        'nom_dist' => 'Nombre Distrito',
        'nom_cp' => 'Nombre Centro Poblado',
        'u_formul' => 'Unidad Formuladora',
        'u_ejec' => 'Unidad Ejecutora',
        'ger_direc' => 'Gerencia/Dirección',
        'sector' => 'Sector',
        'progr' => 'Programa',
        'sub_progr' => 'Sub-Programa',
        'm_pip' => 'Monto PIP',
        'm_viab' => 'Monto Viable',
        'm_exptec' => 'Monto Expediente Técnico',
        'etapa' => 'Etapa',
        'sub_etapa' => 'Sub-Etapa',
        'est_pry' => 'Estado del Proyecto',
        'situa_pro' => 'Siatuación del proyecto',
        'f_etapsub' => 'Fecha de Etapa - Sub-etapa',
        'cant_meta' => 'Cantidad de metas',
        'meta_actual' => 'Meta Actual',
        'm_pim' => 'Monto PIM',
        'm_pim_acu' => 'Monto PIM acumulado',
        'm_deveng' => 'Monto devengado',
        'm_deveng_a' => 'MOnto devengado acumulado',
        'f_deveng_a' => 'Fecha de actualización Financiera',
        'f_adjudica' => 'Fecha Adjudicación',
        'm_ejec' => 'Monto Ejecutado',
        'nro_contrato' => 'Número de contrato',
        'f_i_obra' => 'Fecha Inicio de obra',
        'f_f_obra' => 'Fecha Fin de obra',
        't_ejec_dia' => 'Total ejecutado Diario',
        'a_fisico' => 'Avance Fisico',
        'f_afisico' => 'Fecha avance físico',
        'a_financ' => 'Avance Financiero',
        'tdr_pdf' => 'TDR',
        'f_tdr' => 'Fecha de TDR',
        'a_tdr' => 'Avance TDR',
        'perfil_pdf' => 'Perfil',
        'f_perfil' => 'Fecha de perfil',
        'a_perfil' => 'Avance de perfil',
        'exptec_pdf' => 'Expediente Técnico',
        'f_exptec' => 'Fecha Expediente Técnico',
        'a_exptec' => 'Avance Expediente Técnico',
        'ejec_pdf' => 'Ejecucion',
        'f_ejec' => 'Fecha Ejecución',
        'a_ejec' => 'Avance Ejecución',
        'liquid_pdf' => 'Liquidacion',
        'f_liquid' => 'Fecha Liquidación',
        'a_liquid' => 'Avance Liquidación',
        'transf_pdf' => 'Tranferencia',
        'f_transf' => 'Fecha Tranferencia',
        'a_transf' => 'Avance Tranferencia',
        'b_pogres' => 'Barra de progreso',
        'latitud' => 'Latitud',
        'longitud' => 'Longiud',
        'anio_ini_pry' => 'Año del Proyecto',
        'ubigeo' => 'Ubigeo',
        'anio_pic' => 'Año PIC',
        'mpp_pic' => '',
        'macr_pic' => '',
        'nacuerdo_pic' => '',
        'mpia_pic' => '',
        'estado_pic' => 'Estado del PIC',
        'ffoto_antes' => 'Fecha Foto Antes',
        'ffoto_durante' => 'Fecha Foto Durante',
        'ffoto_despues' => 'Fecha Foto Despues',
        'tipo_pry' => 'Tipo de proyecto',
        'fuente' => 'Fuente',
        'idusuario' => 'uidUsuario',
        'ult_anio_ejec_pry' => 'Ultimo año de ejecución del proyecto',
        'fech_reinico_obra' => 'Fecha de reinicio de obra',
        'nuev_fech_termino' => 'Nueva fecha de termino',
        'estado_antiguedad_pry' => 'Estado Antiguedad del proyecto',
        'tipo_ejec' => 'Tipo de Ejecución',
            #OBRAS
            'nom_meta' => 'Nombre de Meta',
            'anio_ejec' => 'Año de ejecución',
            'mod_ejec' => 'Modalidad de Ejecución',
            'f_adjudicacion' => 'Fecha de Adjudicación',
            'n_contrato' => 'Número de Contrato',
            'f_inicio' => 'Fecha de Inicio',
            'f_termino' => 'Fecha de Termino',
            't_ejec_dia' => 'Tiempo de Ejecución',
            'f_reinicio' => 'Fecha de Reinicio',
            'f_termino_nueva' => 'Nueva Fecha de Término',
            'f_inaug' => 'Fecha de Inauguración',
        'est_situ' => 'Descripcion de estado',
        'sub_etapa' => 'Sub Etapa',
        'nro_meta' => 'N° de meta',
        'fecha_act' => 'Fecha de actualización'
        ],

];
