<?php

namespace hacklabr;

function crm_map_pl_estado( $uf ) {
    $ufs = [
        'AC' => 7,
        'AL' => 15,
        'AM' => 1,
        'AP' => 3,
        'BA' => 16,
        'CE' => 10,
        'DF' => 20,
        'ES' => 23,
        'GO' => 19,
        'MA' => 8,
        'MG' => 24,
        'MS' => 18,
        'MT' => 17,
        'PA' => 4,
        'PB' => 13,
        'PE' => 12,
        'PI' => 9,
        'PR' => 25,
        'RJ' => 22,
        'RN' => 11,
        'RO' => 6,
        'RR' => 2,
        'RS' => 26,
        'SC' => 27,
        'SE' => 14,
        'SP' => 21,
        'TO' => 5,
    ];

    return $ufs[ $uf ] ?? $uf;
}

function crm_map_pl_porte( $size ) {
    $sizes = [
        'micro'  => 969830000,
        'small'  => 969830001,
        'medium' => 969830002,
        'large'  => 969830004,
    ];

    return $sizes[ $size ] ?? $size;
}

function crm_map_account_attributes( $post_id ) {
    $systemuser = get_option( 'systemuser' );

    $post_meta = get_post_meta( $post_id );

    $company_name = $post_meta['nome_fantasia'][0];

    $attributes = [
        'ownerid'                   => create_crm_reference( 'systemuser', $systemuser ),
        'address1_city'             => $post_meta['end_cidade'][0] ?? '',
        'address1_postalcode'       => $post_meta['end_cep'][0] ?? '',
        'entityimage_url'           => \get_the_post_thumbnail_url( $post_id ),
        'fut_address1_line2'        => $post_meta['end_complemento'][0] ?? '',
        'fut_address1_line3'        => $post_meta['end_bairro'][0] ?? '',
        'fut_address1_logradouro'   => $post_meta['end_logradouro'][0] ?? '',
        'fut_address1_nro'          => $post_meta['end_numero'][0] ?? '',
        'fut_lk_cnaename'           => $post_meta['cnae'][0] ?? '',
        'fut_st_cnpj'               => $$post_meta['cnpj'][0],
        'fut_st_complementoorigem'  => $post_meta['segmento'][0] ?? '',
        'fut_st_inscricaoestadual'  => $post_meta['inscricao_estadual'][0] ?? '',
        'fut_st_inscricaomunicipal' => $post_meta['inscricao_municipal'][0] ?? '',
        'fut_st_razaosocial'        => $post_meta['razao_social'][0] ?? '',
        'fut_pl_estado'             => crm_map_pl_estado( $post_meta['end_estado'][0] ?? '' ),
        'fut_pl_porte'              => crm_map_pl_porte( $post_meta['porte'][0] ?? '' ),
        'name'                      => $company_name,
        'numberofemployees'         => $post_meta['num_funcionarios'][0] ?? 0,
        'websiteurl'                => $post_meta['website'][0] ?? '',
        'yominame'                  => $company_name,
    ];

    return $attributes;
}

function crm_map_lead_attributes( $post_id ) {
    $systemuser = get_option( 'systemuser' );

    $author_id = get_post_field( 'post_author', $post_id );
    $author_name = get_the_author_meta( 'display_name', $author_id );

    $name_parts = explode( ' ', $author_name );
    $first_name = $name_parts[0];
    unset( $name_parts[0] );
    $last_name = implode( ' ', $name_parts );

    $post_meta = get_post_meta( $post_id );

    $company_name = $post_meta['nome_fantasia'][0];

    $attributes = [
        'ownerid'                    => create_crm_reference( 'systemuser', $systemuser ),
        'address1_city'              => $post_meta['end_cidade'][0] ?? '',
        'address1_postalcode'        => $post_meta['end_cep'][0] ?? '',
        'companyname'                => $company_name,
        'entityimage_url'            => \get_the_post_thumbnail_url( $post_id ),
        'firstname'                  => $company_name,
        'fullname'                   => $company_name,
        'fut_address1_logradouro'    => $post_meta['end_logradouro'][0] ?? '',
        'fut_address1_nro'           => $post_meta['end_numero'][0] ?? '',
        'fut_st_cnpj'                => $$post_meta['cnpj'][0],
        'fut_st_complementoorigem'   => $post_meta['segmento'][0] ?? '',
        'fut_st_inscricaoestadual'   => $post_meta['inscricao_estadual'][0] ?? '',
        'fut_st_inscricaomunicipal'  => $post_meta['inscricao_municipal'][0] ?? '',
        'fut_st_nome'                => $first_name,
        'fut_st_nomecompleto'        => $author_name,
        'fut_st_nomefantasiaempresa' => $company_name,
        'fut_st_sobrenome'           => $last_name,
        'leadsourcecode'             => 4, // Outros
        'websiteurl'                 => $post_meta['website'][0] ?? '',
        'yomifirstname'              => $first_name,
        'yomifullname'               => $company_name,
        'yomilastname'               => $last_name,
    ];

    return $attributes;
}

function crm_add_contact_to_account( $user_id, $post_id ) {
    $account_id = get_post_meta( $post_id, '_ethos_crm_account_id', true );
    $contact_id = get_user_meta( $user_id, '_ethos_crm_contact_id', true );

    if ( ! empty( $account_id ) && ! empty( $contact_id ) ) {
        try {
            update_crm_entity( 'contact', $contact_id, [
                'parentcustomerid' => create_crm_entity( 'account', $account_id ),
            ] );
        } catch ( \Throwable $err ) {
            do_action( 'logger', $err->getMessage() );
        }
    }
}

function crm_create_account( $post_id ) {
    // @TODO
    try {
        $systemuser = get_option( 'systemuser' );

        $attributes = [
            'ownerid' => create_crm_reference( 'systemuser', $systemuser ),
        ];
    } catch ( \Throwable $err ) {
        do_action( 'logger', $err->getMessage() );
    }

    return null;
}

function crm_create_contact( $user_id, $post_id ) {
    $account_id = get_post_meta( $post_id, '_ethos_crm_account_id', true );

    if ( ! empty( $account_id ) ) {
        try {
            $attributes = [
                'accountid' => create_crm_reference( 'account', $account_id ),
            ];

            $contact_id = create_crm_entity( 'contact', $attributes );

            wp_update_user( [
                'ID' => $user_id,
                'meta_input' => [
                    '_ethos_crm_account_id' => $account_id,
                    '_ethos_crm_contact_id' => $contact_id,
                ],
            ] );

            return $contact_id;
        } catch ( \Throwable $err ) {
            do_action( 'logger', $err->getMessage() );
        }
    }

    return null;
}

function crm_create_lead( $post_id ) {
    $result = send_lead_to_crm( $post_id );

    if ( $result['status'] === 'success' ) {
        return $result['entity_id'];
    } else {
        return null;
    }
}

function crm_update_account( $post_id ) {
    // @TODO
}

function crm_update_contact( $user_id ) {
    // @TODO
}

function crm_update_lead( $post_id ) {
    // @TODO
}
