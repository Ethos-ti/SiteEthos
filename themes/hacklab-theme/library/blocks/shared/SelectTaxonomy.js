import { SelectControl } from '@wordpress/components';
import { useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { useRestApi } from './hooks';
import { sortByString } from './utils';

function getOptions (taxonomies) {
    return Object.values(taxonomies ?? [])
        .map((taxonomy) => ({
            label: taxonomy.label,
            value: taxonomy.slug,
        }))
        .sort(sortByString('label'));
}

export function SelectTaxonomy ({ label = __('Taxonomy'), postType, required = false, value, onChange }) {
    const taxonomies = useRestApi(`hacklabr/v2/taxonomies/${postType}`);

    const options = useMemo(() => {
        const baseOptions = getOptions(taxonomies);
        return required ? baseOptions : [{ label: __('No taxonomy', 'hacklabr'), value: '' }, ...baseOptions];
    }, [taxonomies]);

    return (
        <SelectControl
            label={label}
            options={options}
            value={value}
            onChange={onChange}
        />
    )
}
