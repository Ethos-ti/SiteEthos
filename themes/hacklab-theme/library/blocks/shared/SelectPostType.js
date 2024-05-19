import { SelectControl } from '@wordpress/components';
import { useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

import { useRestApi } from './hooks';
import { sortByString } from './utils';

function getOptions (postTypes) {
    return Object.values(postTypes ?? [])
        .map((postType) => ({
            label: postType.label,
            value: postType.slug,
        }))
        .sort(sortByString('label'));
}

export function SelectPostType ({ label = __('Post type'), required = false, value, onChange }) {
    const postTypes = useRestApi('hacklabr/v2/post_types');

    const options = useMemo(() => {
        const baseOptions = getOptions(postTypes);
        return required ? baseOptions : [{ label: __('No post type', 'hacklabr'), value: '' }, ...baseOptions];
    }, [postTypes]);

    return (
        <SelectControl
            label={label}
            options={options}
            value={value}
            onChange={onChange}
        />
    )
}
