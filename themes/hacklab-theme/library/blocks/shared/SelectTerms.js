import { FormTokenField } from '@wordpress/components';
import { useDebounce } from '@wordpress/compose';
import { useMemo, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { useRestApi } from './hooks';

export function SelectTerms ({ label = __('Terms'), taxonomy, value, onChange }) {
    const [search, setSearch] = useState('');
    const setDebouncedSearch = useDebounce(setSearch, 500);

    const terms = useRestApi(`hacklabr/v2/terms/${taxonomy}`);
    const searchedTerms = useRestApi(`hacklabr/v2/terms/${taxonomy}`, { search });

    const suggestions = useMemo(() => {
        if (!searchedTerms) {
            return [];
        }

        return Object.values(searchedTerms).map((term) => term.name);
    }, [searchedTerms]);

    const tokens = useMemo(() => {
        if (!terms) {
            return value;
        }

        return value.map((token) => terms[token]?.name).filter(Boolean);
    }, [terms, value]);

    const onChangeTokens = (tokens) => {
        if (!terms) {
            return;
        }

        const slugs = tokens
            .map((token) => Object.values(terms).find((term) => term.name === token)?.slug)
            .filter(Boolean);

        onChange(slugs);
    };

    return (
        <FormTokenField
            label={label}
            suggestions= {suggestions}
            value={tokens}
            onChange={onChangeTokens}
            onInputChange={setDebouncedSearch}
        />
    );
}
