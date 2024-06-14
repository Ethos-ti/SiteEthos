import { FormTokenField, SelectControl } from '@wordpress/components';
import { useMemo, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { useRestApi } from './hooks';
import { EMPTY_ARR, sortByString } from './utils';

function filterOptions (taxonomies, search) {
    const input = search.toLocaleLowerCase();

    return taxonomies.filter((taxonomy) => {
        return taxonomy.label.toLocaleLowerCase().includes(input);
    });
}

function getOptions (taxonomies) {
    if (!taxonomies) {
        return EMPTY_ARR;
    }

    return Object.values(taxonomies)
        .map((taxonomy) => ({
            label: taxonomy.label,
            value: taxonomy.slug,
        }))
        .sort(sortByString('label'));
}

export function SelectTaxonomies ({ label = __('Taxonomies', 'hacklabr'), postType, value, onChange }) {
    const [search, setSearch] = useState('');

    const { data: taxonomies } = useRestApi(`hacklabr/v2/taxonomies/${postType}`);

    const options = useMemo(() => {
        return getOptions(taxonomies);
    }, [taxonomies]);

    const searchedOptions = useMemo(() => {
        if (!options) {
            return EMPTY_ARR;
        }

        return filterOptions(options, search);
    }, [options, search]);

    const suggestions = useMemo(() => {
        if (!searchedOptions) {
            return EMPTY_ARR;
        }

        return searchedOptions.map((taxonomy) => taxonomy.label);
    }, [searchedOptions]);

    const tokens = useMemo(() => {
        if (!options) {
            return value;
        }

        return value.map((token) => taxonomies?.[token]?.label).filter(Boolean);
    }, [options, value]);

    const onTokensChange = (tokens) => {
        if (!tokens) {
            return;
        }

        const slugs = tokens
            .map((token) => options.find((option) => option.label === token)?.value)
            .filter(Boolean);

        onChange(slugs);
    };

    return (options.length > 0) ? (
        <FormTokenField
            label={label}
            suggestions= {suggestions}
            value={tokens}
            onChange={onTokensChange}
            onInputChange={setSearch}
        />
    ) : null;
}
