<?php

namespace hacklabr;

function register_registration_form () {
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
            'options' => [],
            'required' => true,
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

    register_form('member-registration-1', __('Member registration - step 1', 'hacklabr'), [
        'fields' => $fields,
        'submit_label' => __('Continue', 'hacklabr'),
    ]);
}
add_action('init', 'hacklabr\\register_registration_form');

function validate_registration_form ($form_id, $form, $params) {
    if ($form_id === 'member-registration-1') {
        $validation = validate_form($form['fields'], $params);

        if ($validation === true) {

        }
    }
}
add_action('hacklabr\\form_action', 'hacklabr\\validate_registration_form', 10, 3);
