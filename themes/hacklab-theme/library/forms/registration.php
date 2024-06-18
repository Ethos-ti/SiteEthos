<?php

namespace hacklabr;

function get_registration_step1_fields () {
    $revenue_options = [
        'small' => 'Micro e pequeno (até R$ 16 milhões)',
        'medium' => 'Médio (R$ 16 a 300 milhões)',
        'large' => 'Grande (maior que R$ 300 milhões)',
    ];

    $states_options = [
		'AC' => 'Acre',
		'AL' => 'Alagoas',
		'AP' => 'Amapá',
		'AM' => 'Amazonas',
		'BA' => 'Bahia',
		'CE' => 'Ceará',
		'DF' => 'Distrito Federal',
		'ES' => 'Espírito Santo',
		'GO' => 'Goiás',
		'MA' => 'Maranhão',
		'MT' => 'Mato Grosso',
		'MS' => 'Mato Grosso do Sul',
		'MG' => 'Minas Gerais',
		'PA' => 'Pará',
		'PB' => 'Paraíba',
		'PR' => 'Paraná',
		'PE' => 'Pernambuco',
		'PI' => 'Piauí',
		'RJ' => 'Rio de Janeiro',
		'RN' => 'Rio Grande do Norte',
		'RS' => 'Rio Grande do Sul',
		'RO' => 'Rondônia',
		'RR' => 'Roraima',
		'SC' => 'Santa Catarina',
		'SP' => 'São Paulo',
		'SE' => 'Sergipe',
		'TO' => 'Tocantins',
	];

    $fields = [
        'cnpj' => [
            'type' => 'masked',
            'class' => '-colspan-12',
            'label' => 'CNPJ',
            'mask' => '00.000.000/0000-00',
            'placeholder' => 'Insira o CNPJ da empresa',
            'required' => true,
            'validate' => function ($value, $context) {
                if (!is_numeric($value) || strlen($value) !== 14) {
                    return 'CNPJ inválido';
                }
                return true;
            },
        ],
        'razao_social' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => 'Razão social',
            'placeholder' => 'Insira a razão social',
            'required' => true,
        ],
        'nome_fantasia' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => 'Nome fantasia',
            'placeholder' => 'Insira o nome fantasia',
            'required' => true,
        ],
        'segmento' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => 'Setor / segmento',
            'placeholder' => 'Insira o setor/segmento da empresa',
            'required' => true,
        ],
        'cnae' => [
            'type' => 'masked',
            'class' => '-colspan-12',
            'label' => 'CNAE',
            'mask' => '0000-0/00',
            'placeholder' => 'Insira o CNAE da empresa',
            'required' => true,
            'validate' => function ($value, $context) {
                if (!is_numeric($value) || strlen($value) !== 7) {
                    return 'CNAE inválido';
                }
                return true;
            },
        ],
        'faturamento_anual' => [
            'type' => 'select',
            'class' => '-colspan-12',
            'label' => 'Faturamento do ano anterior (R$)',
            'options' => $revenue_options,
            'required' => true,
            'validate' => function ($value, $context) use ($revenue_options) {
                if (!array_key_exists($value, $revenue_options)) {
                    return 'Valor inválido';
                }
                return true;
            },
        ],
        'inscricao_estadual' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => 'Inscrição estadual',
            'placeholder' => 'Insira a inscrição estadual',
            'required' => false,
        ],
        'inscricao_municipal' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => 'Inscrição municipal',
            'placeholder' => 'Insira a inscrição municipal',
            'required' => false,
        ],
        'logomarca' => [
            'type' => 'file',
            'class' => '-colspan-12',
            'label' => 'Logomarca da empresa',
            'accept' => 'image/*',
            'hint' => 'A imagem deve estar no tamanho de 164 x 164 pixels',
            'required' => false,
        ],
        'website' => [
            'type' => 'url',
            'class' => '-colspan-12',
            'label' => 'Website',
            'placeholder' => 'www.linkdosite.com.br',
            'required' => true,
        ],
        'num_funcionarios' => [
            'type' => 'number',
            'class' => '-colspan-12',
            'label' => 'Quantidade de funcionários',
            'placeholder' => 'Insira a quantidade de funcionários da empresa',
            'required' => true,
        ],
        'porte' => [
            'type' => 'select',
            'class' => '-colspan-12',
            'label' => 'Porte',
            'options' => [],
            'required' => false,
        ],
        'end_logradouro' => [
            'type' => 'text',
            'class' => '-colspan-9',
            'label' => 'Endereço (logradouro)',
            'placeholder' => 'Insira o logradouro do endereço',
            'required' => true,
        ],
        'end_numero' => [
            'type' => 'text',
            'class' => '-colspan-3',
            'label' => 'Número',
            'required' => true,
        ],
        'end_complemento' => [
            'type' => 'text',
            'class' => '-colspan-6',
            'label' => 'Complemento',
            'placeholder' => 'Insira o complemento',
            'required' => false,
        ],
        'end_bairro' => [
            'type' => 'text',
            'class' => '-colspan-6',
            'label' => 'Bairro',
            'placeholder' => 'Insira o bairro',
            'required' => true,
        ],
        'end_cidade' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => 'Cidade',
            'placeholder' => 'Insira a cidade',
            'required' => true,
        ],
        'end_estado' => [
            'type' => 'select',
            'class' => '-colspan-6',
            'label' => 'Estado',
            'options' => $states_options,
            'required' => true,
            'validate' => function ($value, $context) use ($states_options) {
                if (!array_key_exists($value, $states_options)) {
                    return 'Estado inválido';
                }
                return true;
            },
        ],
        'end_cep' => [
            'type' => 'masked',
            'class' => '-colspan-6',
            'label' => 'CEP',
            'mask' => '00000-000',
            'placeholder' => 'Insira o CEP',
            'required' => true,
            'validate' => function ($value, $context) {
                if (!is_numeric($value) || strlen($value) !== 8) {
                    return 'CEP inválido';
                }
                return true;
            },
        ],
        'termos_de_uso' => [
            'type' => 'checkbox',
            'class' => '-colspan-12',
            'label' => 'Li e concordo com os <a href="' . get_privacy_policy_url() . '">termos de uso de dados</a> pelo Instituto Ethos',
            'required' => true,
        ],
    ];

    return $fields;
}

function get_registration_step2_fields () {
    $fields = [
        'nome_completo' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => 'Nome completo',
            'placeholder' => 'Insira o nome completo',
            'required' => true,
        ],
        'cpf' => [
            'type' => 'masked',
            'class' => '-colspan-12',
            'label' => 'CPF',
            'mask' => '000.000.000-00',
            'placeholder' => 'Insira o CPF do responsável',
            'required' => true,
            'validate' => function ($value, $context) {
                if (!is_numeric($value) || strlen($value) !== 11) {
                    return 'CPF inválido';
                }
                return true;
            },
        ],
        'cargo' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => 'Cargo',
            'placeholder' => 'Insira o cargo na empresa',
            'required' => true,
        ],
        'area' => [
            'type' => 'text',
            'class' => '-colspan-12',
            'label' => 'Área',
            'placeholder' => 'Descreva a área na empresa',
            'required' => true,
        ],
        'email' => [
            'type' => 'email',
            'class' => '-colspan-12',
            'label' => 'Email',
            'placeholder' => 'Insira o e-mail',
            'required' => true,
        ],
        'senha' => [
            'type' => 'password',
            'class' => '-colspan-12',
            'label' => 'Senha',
            'placeholder' => 'Insira a senha',
            'required' => true,
        ],
        'celular' => [
            'type' => 'masked',
            'class' => '-colspan-12',
            'label' => 'Celular',
            'mask' => '(00) 0000-0000|(00) 00000-0000',
            'placeholder' => 'Insira o número de celular',
            'required' => true,
            'validate' => function ($value, $context) {
                if (!is_numeric($value) || strlen($value) < 10 || strlen($value) > 11) {
                    return 'Número de celular inválido';
                }
                return true;
            },
        ],
        'celular_is_whatsapp' => [
            'type' => 'checkbox',
            'class' => '-colspan-12',
            'label' => 'Este número também é WhatsApp',
            'required' => false,
        ],
        'telefone' => [
            'type' => 'masked',
            'class' => '-colspan-12',
            'label' => 'Telefone',
            'mask' => '(00) 0000-0000',
            'placeholder' => 'Insira o número de telefone',
            'required' => false,
            'validate' => function ($value, $context) {
                if (empty($value)) {
                    return true;
                } elseif (!is_numeric($value) || strlen($value) !== 10) {
                    return 'Número de telefone inválido';
                }
                return true;
            },
        ],
    ];

    return $fields;
}

function register_registration_form () {
    $fields_step1 = get_registration_step1_fields();
    $fields_step2 = get_registration_step2_fields();

    register_form('member-registration-1', __('Member registration - step 1', 'hacklabr'), [
        'fields' => $fields_step1,
        'submit_label' => __('Continue', 'hacklabr'),
    ]);

    register_form('member-registration-2', __('Member registration - step 2', 'hacklabr'), [
        'back_label' => __('Back', 'hacklabr'),
        'back_url' => get_permalink(get_page_by_form('member-registration-1')),
        'fields' => $fields_step2,
        'hidden_fields' => array_keys($fields_step1),
        'submit_label' => __('Continue', 'hacklabr'),
    ]);
}
add_action('init', 'hacklabr\\register_registration_form');

function validate_registration_form ($form_id, $form, $params) {
    if ($form_id === 'member-registration-1') {
        $validation = validate_form($form['fields'], $params);

        if ($validation !== true) {
            return;
        }

        $post_meta = $params;
        unset($post_meta['_hacklabr_form']);

        $post_id = wp_insert_post([
            'post_type' => 'organizacao',
            'post_title' => $params['nome_fantasia'],
            'post_content' => '',
            'post_status' => 'draft',
            'meta_input' => $post_meta,
        ]);

        $next_page = get_page_by_form('member-registration-2');
        $params = [ 'orgid' => $post_id ];

        wp_safe_redirect(add_query_arg($params, get_permalink($next_page)));
        exit;
    }

    if ($form_id === 'member-registration-2' && !empty($_GET['orgid'])) {
        $validation = validate_form($form['fields'], $params);

        if ($validation !== true) {
            return;
        }

        $post_id = (int) filter_input(INPUT_GET, 'orgid', FILTER_VALIDATE_INT);

        $user_meta = $params;
        $password = $params['senha'];
        unset($user_meta['_hacklabr_form']);
        unset($user_meta['senha']); // Don't store plaintext password

        $user_id = wp_insert_user([
            'display_name' => $params['nome_completo'],
            'user_email' => $params['email'],
            'user_pass' => $password,
            'role' => 'subscriber',
            'meta_input' => $user_meta,
        ]);

        $group = create_pmpro_group($user_id);

        wp_insert_post([
            'ID' => $post_id,
            'post_status' => 'publish',
            'post_author' => $user_id,
            'meta_input' => [
                '_pmpro_group' => $group->id,
            ],
        ]);

        wp_safe_redirect(get_home_url());
        exit;
    }
}
add_action('hacklabr\\form_action', 'hacklabr\\validate_registration_form', 10, 3);
