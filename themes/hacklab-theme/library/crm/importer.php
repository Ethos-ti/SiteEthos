<?php

namespace ethos\crm;

use \AlexaCRM\Xrm\Entity;

/**
 * Better than calling `array_filter` than `array_unique` because the latter
 * preserve keys
 */
function array_unique_values( array $array ) {
    $return = [];

    foreach ( $array as $el ) {
        if ( ! empty( $el ) && ! in_array( $el, $return ) ) {
            $return[] = $el;
        }
    }

    return $return;
}

function sanitize_number( string $string ) {
    if ( empty( $string ) ) {
        return '';
    }
    return str_replace( [ '+', '-' ], '', filter_var( $string, FILTER_SANITIZE_NUMBER_INT ) );
}

function generate_unique_email( string $email, Entity $account ) {
    $email_parts = explode( '@', $email );
    $folder = sanitize_title( $account->Attributes['name'] );
    return $email_parts[0] . '+' . $folder . '@' . $email_parts[1];
}

function is_parent_company( Entity $account ) {
    return strlen( $account->Attributes['fut_txt_childnode'] ?? '' ) > 169;
}

function is_subsidiary_company( Entity $account ) {
    return $account->Attributes['fut_bt_pertencegrupo'] ?? false;
}

function compute_contact_role( Entity $contact ) {
    $attributes = $contact->Attributes;

    if ( $attributes['fut_bt_principal'] ?? false ) {
        return 'primary';
    } elseif ( $attributes['fut_bt_financeiro'] ?? false ) {
        return 'financial';
    } else {
        return 'secondary';
    }
}

function get_account_by_contact( Entity $contact ) {
    $account_id = $contact->Attributes['parentcustomerid']?->Id ?? null;
    if ( empty( $account_id ) ) {
        return null;
    }
    return \hacklabr\get_crm_entity_by_id( 'account', $account_id ) ?? null;
}

function is_active_account( Entity $account ) {
    $account_status = $account->FormattedValues['fut_pl_associacao'] ?? '';
    return in_array( $account_status, ['Associado', 'Grupo Econômico'] );
}

function is_active_contact( Entity $contact, Entity|null $account = null ) {
    if ( ! ContactStatus::isActive( $contact->Attributes['statecode'] ) ) {
        return false;
    }

    if ( empty( $account ) ) {
        $account = get_account_by_contact( $contact );

        if ( empty( $account ) ) {
            return false;
        }
    }
    return is_active_account( $account );
}

function get_post_id_by_account( string $account_id ) {
    $existing_post = get_single_post( [
        'post_type' => 'organizacao',
        'meta_query' => [
            [ 'key' => '_ethos_crm_account_id', 'value' => $account_id ],
        ],
    ] );

    if ( empty( $existing_post ) ) {
        $account = \hacklabr\get_crm_entity_by_id( 'account', $account_id );

        if ( ! empty( $account ) ) {
            return \ethos\migration\import_account( $account, false );
        }

        return null;
    }

    return $existing_post->ID;
}

function parse_account_into_post_meta( Entity $account ) {
    $account_id = $account->Id;
    $attributes = $account->Attributes;
    $formatted = $account->FormattedValues;

    $revenue_base = $attributes['revenue_base'] ?? 0;
    if ( $revenue_base < 10_000_000 ) {
        $revenue = 'small';
    } elseif ( $revenue_base < 300_000_000 ) {
        $revenue = 'medium';
    } else {
        $revenue = 'large';
    }

    $size = CompanySize::toSlug( $attributes['fut_pl_porte'] ?? null );

    if ( ! empty( $attributes['entityimage_url'] ) ) {
        $logo = \hacklabr\get_crm_server_url() . $attributes['entityimage_url'];
    } else {
        $logo = '';
    }

    $logradouro = trim( $attributes['fut_address1_logradouro'] ?? '' );
    if ( ! empty( $attributes['fut_lk_tipologradouro']?->Name ) ) {
        $logradouro_prefix = trim( $attributes['fut_lk_tipologradouro']->Name );

        if ( ! str_starts_with( strtolower( $logradouro ), strtolower( $logradouro_prefix ) ) ) {
            $logradouro = $logradouro_prefix . ' ' . $logradouro;
        }
    }

    if ( ! empty( $attributes['originatingleadid'] ) ) {
        $lead_id = $attributes['originatingleadid']->Id;
    } else {
        $lead_id = null;
    }

    $post_meta = [
        '_ethos_from_crm' => 1,
        '_ethos_crm_account_id' => $account_id,
        '_ethos_crm_lead_id' => $lead_id,

        'cnpj' => trim( $attributes['fut_st_cnpjsemmascara'] ?? '' ),
        'razao_social' => trim( $attributes['fut_st_razaosocial'] ?? '' ),
        'nome_fantasia' => trim( $attributes['name'] ?? '' ),
        'segmento' => trim( $attributes['fut_lk_setor']?->Name ?? '' ),
        'cnae' => sanitize_number( $formatted['fut_lk_cnae'] ?? '' ),
        'faturamento_anual' => $revenue,
        'inscricao_estadual' => trim( $attributes['fut_st_inscricaoestadual'] ?? '' ),
        'inscricao_municipal' => trim( $attributes['fut_st_inscricaomunicipal'] ?? '' ),
        'logomarca' => $logo,
        'website' => trim( $attributes['websiteurl'] ?? '' ),
        'num_funcionarios' => $attributes['numberofemployees'] ?? 0,
        'porte' => $size,
        'end_logradouro' => $logradouro,
        'end_numero' => trim( $attributes['fut_address1_nro'] ?? '' ),
        'end_complemento' => trim( $attributes['address1_line2'] ?? '' ),
        'end_bairro' => trim( $attributes['address1_line3'] ?? '' ),
        'end_cidade' => trim( $attributes['address1_city'] ?? '' ),
        'end_estado' => $formatted['fut_pl_estado'] ?? '',
        'end_cep' => sanitize_number( $attributes['address1_postalcode'] ?? '' ),
    ];

    foreach ( $attributes as $key => $value ) {
        if ( is_array( $value ) || is_object( $value ) ) {
            $post_meta['_ethos_crm:' . $key ] = json_encode( $value );
        } elseif ( ! empty( $value ) || is_numeric( $value ) ) {
            $post_meta['_ethos_crm:' . $key ] = $value;
        }
    }

    return $post_meta;
}

function parse_contact_into_user_meta( Entity $contact, Entity|null $account ) {
    $contact_id = $contact->Id;
    $attributes = $contact->Attributes;
    $formatted = $contact->FormattedValues;

    $phones = [
        sanitize_number( $attributes['mobilephone'] ?? '' ),
        sanitize_number( $attributes['telephone1'] ?? '' ),
        sanitize_number( $attributes['telephone2'] ?? '' ),
    ];
    $phones = array_unique_values( $phones );

    $email = trim( $attributes['emailaddress1'] ?? '@' );
    if ( ! empty( $account ) && is_subsidiary_company( $account ) ) {
        $email = generate_unique_email( $email, $account );
    }

    $user_meta = [
        '_ethos_from_crm' => 1,
        '_ethos_crm_account_id' => $attributes['parentcustomerid']?->Id ?? '',
        '_ethos_crm_contact_id' => $contact_id,
        '_pmpro_role' => compute_contact_role( $contact ),

        'nome_completo' => trim( $attributes['fullname'] ?? '' ),
        'cpf' => sanitize_number( $attributes['fut_st_cpf'] ?? '' ),
        'cargo' => trim( $attributes['jobtitle'] ?? '' ),
        'area' => trim( $formatted['fut_pl_area'] ?? '' ),
        'email' => $email,
        'celular' => $phones[ 0 ] ?? '',
        'celular_is_whatsapp' => '',
        'telefone' => $phones[ 1 ] ?? '',
    ];

    foreach ( $attributes as $key => $value ) {
        if ( is_array( $value ) || is_object( $value ) ) {
            $user_meta['_ethos_crm:' . $key ] = json_encode( $value );
        } elseif ( ! empty( $value ) || is_numeric( $value ) ) {
            $user_meta['_ethos_crm:' . $key ] = $value;
        }
    }

    return $user_meta;
}
