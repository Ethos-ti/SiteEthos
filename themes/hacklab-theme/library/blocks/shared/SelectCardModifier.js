import { FormTokenField } from '@wordpress/components';
import { useMemo, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { useRestApi } from './hooks';
import { EMPTY_ARR, sortByString } from './utils';

function filterOptions (modifiers, search) {
    const input = search.toLocaleLowerCase();

    return modifiers.filter((modifier) => {
        return modifier.label.toLocaleLowerCase().includes(input);
    });
}

function getOptions (cardModifiers) {
    if (!cardModifiers) {
        return EMPTY_ARR;
    }

    return Object.values(cardModifiers.options)
        .map((cardModifier) => ({
            label: cardModifier.label,
            value: cardModifier.slug,
        }))
        .sort(sortByString('label'));
}

export function SelectCardModifier ({ label = __('Card modifier', 'hacklabr'), value, onChange }) {
    const [search, setSearch] = useState('');

    const { data: settings } = useRestApi('hacklabr/v2/block_settings');

    const options = useMemo(() => {
        return getOptions(settings?.cardModifiers);
    }, [settings]);

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

        return searchedOptions.map((modifier) => modifier.label);
    }, [searchedOptions]);

    const tokens = useMemo(() => {
        if (!options) {
            return value;
        }

        const rawOptions = settings?.cardModifiers.options;
        return value.map((token) => rawOptions?.[token]?.label).filter(Boolean);
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
